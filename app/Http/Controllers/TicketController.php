<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\Hospital;
use App\Models\Queue;
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

        $tickets = Ticket::with(['queue.service.hospital', 'citoyen'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        if ($user->isAdmin()) {
            $hospitalId = optional($user->administrator)->hospital_id;

            $tickets->when($hospitalId, function ($query) use ($hospitalId) {
                $query->whereHas('queue.service', function ($serviceQuery) use ($hospitalId) {
                    $serviceQuery->where('hospital_id', $hospitalId);
                });
            });
        } elseif ($user->isAgent()) {
            $queueId = optional($user->agent)->queue_id;

            $tickets->when($queueId, function ($query) use ($queueId) {
                $query->where('queue_id', $queueId);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            });
        } else {
            $citoyenId = optional($user->citoyen)->id;

            $tickets->when($citoyenId, function ($query) use ($citoyenId) {
                $query->where('citoyen_id', $citoyenId);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            });
        }

        $tickets = $tickets->latest()->get();

        $statuses = [
            'EN_ATTENTE' => 'En attente',
            'TERMINE' => 'Terminé',
            'ANNULE' => 'Annulé',
        ];

        return view('tickets.index', compact('tickets', 'statuses', 'status'));
    }

    public function create()
    {
        $user = auth()->user();
        $existingActiveTicket = $this->getExistingActiveTicket($user);

        if ($user->isAgent()) {
            $agentQueue = Queue::with('service.hospital')
                ->whereKey(optional($user->agent)->queue_id)
                ->first();

            $queues = $agentQueue ? collect([$agentQueue]) : collect();
            $hospitals = $agentQueue && $agentQueue->service && $agentQueue->service->hospital
                ? collect([$agentQueue->service->hospital])
                : collect();
            $services = $this->formatServices($queues);
            $citoyens = collect();

            return view('tickets.create', compact('queues', 'citoyens', 'hospitals', 'services', 'agentQueue', 'existingActiveTicket'));
        }

        $queues = Queue::with('service.hospital')
            ->whereHas('service.hospital')
            ->get();

        $hospitals = Hospital::query()
            ->orderBy('name')
            ->get();

        $services = $this->formatServices($queues, true);
        $citoyens = $user->isCitoyen()
            ? collect([$user->citoyen])->filter()
            : Citoyen::with('user')->get();

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
        } elseif (! $user->isCitoyen()) {
            $rules['citoyen_id'] = 'required|exists:citoyens,id';
        }

        $data = $request->validate($rules);

        $queue = Queue::with('service')->find($data['queue_id']);

        if (! $queue || ! $queue->service || (string) $queue->service->hospital_id !== (string) $data['hospital_id']) {
            return back()->withErrors([
                'queue_id' => 'La file choisie ne correspond pas à l’hôpital sélectionné.',
            ])->withInput();
        }

        if ($user->isCitoyen() && $queue->status !== 'OPEN') {
            return back()->withErrors([
                'queue_id' => 'Cette file est fermée. Impossible de prendre un ticket pour le moment.',
            ])->withInput();
        }

        if ($user->isAgent()) {
            $agentQueueId = optional($user->agent)->queue_id;

            if ((string) $agentQueueId !== (string) $queue->id) {
                return back()->withErrors([
                    'queue_id' => 'Vous ne pouvez créer un ticket que pour votre propre file.',
                ])->withInput();
            }

            $citoyenId = $this->findOrCreateCitoyenIdByName($request->input('citoyen_name'));
        } else {
            $citoyenId = $user->isCitoyen()
                ? optional($user->citoyen)->id
                : $request->input('citoyen_id');

            if (! $citoyenId) {
                return back()->withErrors([
                    'citoyen_id' => 'Aucun profil citoyen lié à cet utilisateur.',
                ])->withInput();
            }
        }

        $existingActiveTicket = Ticket::where('citoyen_id', $citoyenId)
            ->whereIn('status', ['EN_ATTENTE', 'APPELE', 'EN_COURS'])
            ->first();

        if ($existingActiveTicket) {
            return back()->withErrors([
                'queue_id' => 'Ce citoyen a déjà un ticket actif. Impossible de créer un deuxième ticket en attente.',
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

    public function show(Ticket $ticket)
    {
        $ticket->load(['queue.service.hospital', 'citoyen']);

        return view('tickets.show', compact('ticket'));
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
        if (! $user->isCitoyen() || ! $user->citoyen) {
            return null;
        }

        return Ticket::with('queue.service.hospital')
            ->where('citoyen_id', $user->citoyen->id)
            ->whereIn('status', ['EN_ATTENTE', 'APPELE', 'EN_COURS'])
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
            'password' => Str::random(12),
        ]);

        return Citoyen::create([
            'user_id' => $citoyenUser->id,
        ])->id;
    }
}