<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\Hospital;
use App\Models\Queue;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->string('status')->toString();
        $serviceId = $request->string('service_id')->toString();

        $services = Service::with('hospital')
            ->orderBy('name')
            ->get();

        if ($user->isAdmin()) {
            $hospitalId = $user->administrator->hospital_id;

            $tickets = Ticket::with(['queue.service.hospital', 'citoyen'])
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($serviceId, function ($query) use ($serviceId) {
                    $query->whereHas('queue.service', function ($serviceQuery) use ($serviceId) {
                        $serviceQuery->whereKey($serviceId);
                    });
                })
                ->when($hospitalId, function ($query) use ($hospitalId) {
                    $query->whereHas('queue.service', function ($serviceQuery) use ($hospitalId) {
                        $serviceQuery->where('hospital_id', $hospitalId);
                    });
                });

            if ($hospitalId) {
                $services = Service::with('hospital')
                    ->where('hospital_id', $hospitalId)
                    ->orderBy('name')
                    ->get();
                    }
                    $tickets = $tickets->latest()->get();                    
        } elseif ($user->isAgent()) {

            if ($user->agent) {
                $queueId = $user->agent->queue_id;
            } else {
                $queueId = null;
                }

            if (!$queueId) {
                $tickets = collect();
            } else {
            $tickets = Ticket::with(['queue.service.hospital', 'citoyen'])
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($serviceId, function ($query) use ($serviceId) {
                    $query->whereHas('queue.service', function ($serviceQuery) use ($serviceId) {
                        $serviceQuery->where('id', $serviceId);
                    });
                })
                ->where('queue_id', $queueId)->get();
            }
            $agentQueue = $queueId ? Queue::with('service.hospital')->whereKey($queueId)->first() : null;

            $services = $agentQueue && $agentQueue->service ? collect([$agentQueue->service]) : collect();
        
        } else {
                $citoyenId = $user->citoyen?->id;

                if (!$citoyenId) {
                    $tickets = collect();
                } else {
                $tickets = Ticket::with(['queue.service.hospital', 'citoyen'])
                    ->when($status, function ($query) use ($status) {
                        $query->where('status', $status);
                    })
                    ->when($serviceId, function ($query) use ($serviceId) {
                        $query->whereHas('queue.service', function ($serviceQuery) use ($serviceId) {
                            $serviceQuery->whereKey($serviceId);
                        });
                    })
                        ->where('citoyen_id', $citoyenId)->latest()->get();
            }
            }

        $statuses = [
            'EN_ATTENTE' => 'En attente',
            'TERMINE' => 'Terminé',
            'ANNULE' => 'Annulé',
        ];

        return view('tickets.index', compact('tickets', 'statuses', 'status', 'services', 'serviceId'));
    }

    public function create()
    {
        $user = auth()->user();
        $existingActiveTicket = $this->getExistingActiveTicket($user);

        if ($user->isAgent()) {
            $agentQueue = Queue::with('service.hospital')
                ->where('id', $user->agent?->queue_id)
                ->first();

            $queues = $agentQueue ? collect([$agentQueue]) : collect();
            $hospital = $agentQueue?->service?->hospital;
            $hospitals = $hospital ? collect([$hospital]) : collect();
            $services = $this->formatServices($queues);

            return view('tickets.create', compact('queues', 'hospitals', 'services', 'agentQueue', 'existingActiveTicket'));
        }

        $queues = Queue::with('service.hospital')
            ->whereHas('service.hospital')
            ->get();

        $hospitals = Hospital::query()
            ->orderBy('name')
            ->get();

        $services = $this->formatServices($queues, true);
        if ($user->isCitoyen()) {
            $citoyens = Citoyen::with('user')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $citoyens = Citoyen::with('user')->get();
        }

        $agentQueue = null;

        return view('tickets.create', compact('queues', 'citoyens', 'hospitals', 'services', 'agentQueue', 'existingActiveTicket'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'hospital_id' => 'required|exists:hospitals,id',
            'queue_id' => 'required|exists:queues,id',
        ];

        if ($user->isAgent()) {
            $rules['citoyen_name'] = 'required|string|max:255';
        }

        $data = $request->validate($rules);

        $queue = Queue::with('service')->find($data['queue_id']);

        if ($user->isCitoyen() && $queue->status !== 'OPEN') {
            return back()->withErrors([
                'queue_id' => 'Cette file est fermée. Impossible de prendre un ticket pour le moment.',
            ])->withInput();
        }

        if ($user->isAgent()) {
            $agentQueueId = $user->agent?->queue_id;

            $citoyenId = $this->findOrCreateCitoyenIdByName($request->input('citoyen_name'));
        } else {
            $citoyenId = $user->isCitoyen() ? $user->citoyen?->id : $request->input('citoyen_id');
        }

        $existingActiveTicket = Ticket::where('citoyen_id', $citoyenId)
            ->whereIn('status', ['EN_ATTENTE', 'APPELE'])
            ->first();

        if ($existingActiveTicket) {
            return back()->withErrors([
                'queue_id' => 'Impossible de créer un deuxième ticket en attente.',
            ])->withInput();
        }

        $number = (Ticket::where('queue_id', $data['queue_id'])->max('number') ?? 0) + 1;

        Ticket::create([
            'queue_id' => $data['queue_id'],
            'citoyen_id' => $citoyenId,
            'number' => $number,
            'status' => 'EN_ATTENTE',
        ]);

        return redirect()->route('tickets.index');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index');
    }

    public function cancel(Ticket $ticket)
    {
        $ticket->status = 'ANNULE';
        $ticket->save();

        return redirect()->route('tickets.index');
    }

    private function getExistingActiveTicket($user)
    {
        if (! $user->citoyen) {
            return null;
        }

        return Ticket::with('queue.service.hospital')
            ->where('citoyen_id', $user->citoyen->id)
            ->whereIn('status', ['EN_ATTENTE', 'APPELE'])
            ->latest()
            ->first();
    }

    private function formatServices($queues, $unique = false)
    {
        $services = $queues
            ->map(function ($queue) {
                return [
                    'id' => $queue->service->id,
                    'name' => $queue->service->name,
                    'hospital_id' => $queue->service->hospital->id,
                    'hospital_name' => $queue->service->hospital->name,
                    'queue_id' => $queue->id,
                    'queue_name' => $queue->name,
                    'queue_status' => $queue->status,
                ];
            });

        if ($unique) {
            $services = $services->unique('id')->sortBy('name');
        }

        return $services->values();
    }

    private function findOrCreateCitoyenIdByName($citoyenName)
    {
        $citoyenName = trim((string) $citoyenName);

        $existingCitoyen = Citoyen::with('user')
            ->whereHas('user', function ($query) use ($citoyenName) {
                $query->where('name', $citoyenName);
            })
            ->first();

        if ($existingCitoyen) {
            return $existingCitoyen->id;
        }

        $email = 'citoyen+' . Str::slug($citoyenName, '.') . '.' . Str::lower(Str::random(6)) . '@hospital.local';

        $citoyenUser = User::create([
            'name' => $citoyenName,
            'email' => $email,
            'password' => '123123',
        ]);

        return Citoyen::create([
            'user_id' => $citoyenUser->id,
        ])->id;
    }
}
