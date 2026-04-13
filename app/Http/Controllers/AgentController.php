<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $hospitalId = optional(optional($request->user())->administrator)->hospital_id;

        $agents = Agent::with(['user', 'queue.service.hospital'])
            ->when($hospitalId, function ($query) use ($hospitalId) {
                $query->whereHas('queue.service', function ($serviceQuery) use ($hospitalId) {
                    $serviceQuery->where('hospital_id', $hospitalId);
                });
            })
            ->get();

        return view('agents.index', compact('agents'));
    }

    public function create(Request $request)
    {
        $hospitalId = optional(optional($request->user())->administrator)->hospital_id;

        $queues = Queue::with('service.hospital')
            ->whereHas('service', function ($serviceQuery) use ($hospitalId) {
                $serviceQuery->where('hospital_id', $hospitalId);
            })
            ->whereDoesntHave('agents')
            ->orderBy('name')
            ->get();

        return view('agents.create', compact('queues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'queue_id' => 'required|exists:queues,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        Agent::create([
            'user_id' => $user->id,
            'queue_id' => $request->queue_id,
        ]);

        return redirect()->route('agents.index')
            ->with('success', 'Agent created successfully');
    }

    public function show(Agent $agent)
    {
        $agent->load('user', 'queue.service.hospital');

        return view('agents.show', compact('agent'));
    }

    public function edit(Request $request, Agent $agent)
    {
        $agent->load('queue.service.hospital');

        $hospitalId = optional(optional($request->user())->administrator)->hospital_id;

        $queues = Queue::with('service.hospital')
            ->whereHas('service', function ($serviceQuery) use ($hospitalId) {
                $serviceQuery->where('hospital_id', $hospitalId);
            })
            ->where(function ($query) use ($agent) {
                $query->whereDoesntHave('agents')
                    ->orWhere('id', $agent->queue_id);
            })
            ->orderBy('name')
            ->get();

        return view('agents.edit', compact('agent', 'queues'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'queue_id' => 'required|exists:queues,id',
        ]);

        $agent->update([
            'queue_id' => $request->queue_id,
        ]);

        return redirect()->route('agents.index')
            ->with('success', 'Agent updated');
    }
    
    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')
            ->with('success', 'Agent deleted');
    }
}
