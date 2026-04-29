<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $hospitalId = $this->getAdministratorHospitalId($request);

        $queues = Queue::with('service')
            ->whereHas('service', function ($query) use ($hospitalId) {
                $query->where('hospital_id', $hospitalId);
            })
            ->get();

        return view('queues.index', compact('queues'));
    }

    public function create(Request $request)
    {
        $services = $this->availableServicesForHospital(
            $this->getAdministratorHospitalId($request)
        )->get();

        return view('queues.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
        ]);

        Queue::create([
            'service_id' => $data['service_id'],
            'name' => $data['name'],
            'current_number' => 0,
            'status' => 'OPEN',
        ]);

        return redirect()->route('queues.index');
    }

    public function show(Queue $queue)
    {
        return view('queues.show', compact('queue'));
    }

    public function edit(Request $request, Queue $queue)
    {
        $services = $this->availableServicesForHospital(
            $this->getAdministratorHospitalId($request),
            $queue->service_id
        )->get();

        return view('queues.edit', compact('queue', 'services'));
    }

    public function update(Request $request, Queue $queue)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $queue->update($data);

        return redirect()->route('queues.index');
    }

    public function destroy(Queue $queue)
    {
        $queue->delete();

        return redirect()->route('queues.index');
    }

    public function open(Queue $queue)
    {
        $queue->update([
            'status' => 'OPEN',
        ]);

        return redirect()->back();
    }

    public function close(Queue $queue)
    {
        $queue->update([
            'status' => 'CLOSED',
        ]);

        return redirect()->back();
    }

    public function callNext(Queue $queue)
    {
        if ($queue->status !== 'OPEN') {
            return redirect()->back()->withErrors([
                'queue' => 'Impossible d’appeler un ticket tant que la file est fermée.',
            ]);
        }

        Ticket::where('queue_id', $queue->id)
            ->where('status', 'APPELE')
            ->update([
                'status' => 'TERMINE',
            ]);

        $ticket = $queue->tickets()
            ->where('status', 'EN_ATTENTE')
            ->orderBy('id')
            ->first();

        if (!$ticket) {
            return redirect()->back()->withErrors([
                'queue' => 'Aucun ticket en attente dans cette file.',
            ]);
        }

        $ticket->status = 'APPELE';
        $ticket->save();

        $queue->current_number = $ticket->number;
        $queue->save();

        return redirect()->back()->with('success', 'Le ticket ' . $ticket->number . ' a été appelé.');
    }

    private function getAdministratorHospitalId(Request $request)
    {
        $user = $request->user();

        if ($user && $user->administrator) {
            return $user->administrator->hospital_id;
        }
        return null;
    }

    private function availableServicesForHospital($hospitalId, $currentServiceId = null)
    {
        return Service::where('hospital_id', $hospitalId)
            ->where(function ($query) use ($currentServiceId) {
                $query->whereDoesntHave('queues');

                if ($currentServiceId) {
                    $query->orWhere('id', $currentServiceId);
                }
            });
    }

}
