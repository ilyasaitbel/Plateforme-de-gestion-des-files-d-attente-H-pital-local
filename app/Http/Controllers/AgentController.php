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
        $hospitalId = $request->user()->administrator->hospital_id;

        $agents = Agent::with(['user', 'hospital', 'queue.service'])
            ->when($hospitalId, function ($query) use ($hospitalId) {
                $query->where('hospital_id', $hospitalId);
            })
            ->get();

        return view('agents.index', compact('agents'));
    }

    public function create(Request $request)
    {
        $hospitalId = $request->user()->administrator->hospital_id;

        $queues = $this->availableQueuesForHospital($hospitalId)->get();

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

        $queue = Queue::with('service')->findOrFail($request->queue_id);

        Agent::create([
            'user_id' => $user->id,
            'queue_id' => $queue->id,
            'hospital_id' => $queue->service->hospital_id,
        ]);

        return redirect()->route('agents.index')
            ->with('success', 'Agent created successfully');
    }

    public function show(Agent $agent)
    {
        $agent->load('user', 'hospital', 'queue.service');

        return view('agents.show', compact('agent'));
    }

    public function edit(Request $request, Agent $agent)
    {
        $agent->load('hospital', 'queue.service');

        $hospitalId = $request->user()->administrator->hospital_id;

        $queues = $this->availableQueuesForHospital($hospitalId, $agent->queue_id)->get();

        return view('agents.edit', compact('agent', 'queues'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'queue_id' => 'required|exists:queues,id',
        ]);

        $queue = Queue::with('service')->findOrFail($request->queue_id);

        $agent->update([
            'queue_id' => $queue->id,
            'hospital_id' => $queue->service->hospital_id,
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

    private function availableQueuesForHospital($hospitalId, $currentQueueId = null)
    {
        return Queue::with('service.hospital')
            ->whereHas('service', function ($serviceQuery) use ($hospitalId) {
                $serviceQuery->where('hospital_id', $hospitalId);
            })
            ->where(function ($query) use ($currentQueueId) {
                $query->whereDoesntHave('agents');

                if ($currentQueueId) {
                    $query->orWhere('id', $currentQueueId);
                }
            })
            ->orderBy('name');
    }
}
