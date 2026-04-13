<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\Queue;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class CitoyenController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            $hospitalId = $user->administrator->hospital_id ?? null;

            if (!$hospitalId) {
                $citoyens = collect();

                return view('citoyens', compact('citoyens'));
            }

            $citoyens = Citoyen::with(['user', 'tickets'])
                ->whereHas('tickets.queue.service', function ($query) use ($hospitalId) {
                    $query->where('hospital_id', $hospitalId);
                })
                ->get();

            return view('citoyens', compact('citoyens'));
        }

        $citoyens = Citoyen::with(['user', 'tickets'])->get();

        return view('citoyens', compact('citoyens'));
    }

    public function show(Citoyen $citoyen)
    {
        $citoyen->load(['user', 'tickets']);
        return view('citoyens.show', compact('citoyen'));
    }

    public function create()
    {
        $users = User::all();
        return view('citoyens.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        Citoyen::create($data);

        return redirect()->route('citoyens.index');
    }

    public function edit(Citoyen $citoyen)
    {
        $users = User::all();
        return view('citoyens.edit', compact('citoyen', 'users'));
    }

    public function update(Request $request, Citoyen $citoyen)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $citoyen->update($data);

        return redirect()->route('citoyens.index');
    }

    public function destroy(Citoyen $citoyen)
    {
        $citoyen->delete();

        return redirect()->route('citoyens.index');
    }

    public function requestTicket(Request $request, Citoyen $citoyen)
    {
        $data = $request->validate([
            'queue_id' => 'required|exists:queues,id',
        ]);

        $queue  = Queue::findOrFail($data['queue_id']);
        $number = Ticket::where('queue_id', $queue->id)->max('number') + 1;

        Ticket::create([
            'queue_id'   => $queue->id,
            'citoyen_id' => $citoyen->id,
            'number'     => $number,
            'status'     => 'EN_ATTENTE',
        ]);

        return redirect()->route('tickets.index');
    }

    public function cancelTicket(Citoyen $citoyen, Ticket $ticket)
    {
        if ($ticket->citoyen_id !== $citoyen->id) {
            abort(403);
        }

        $ticket->status = 'ANNULE';
        $ticket->save();

        return redirect()->route('tickets.index');
    }
}