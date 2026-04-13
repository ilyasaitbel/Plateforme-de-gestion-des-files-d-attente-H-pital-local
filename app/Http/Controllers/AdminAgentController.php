<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAgentController extends Controller
{
    public function index()
    {
        $agents = Agent::with(['user', 'hospital'])->latest('id')->get();
        return view('admin.agents.index', compact('agents'));
    }

    public function create()
    {
        $hospitals = Hospital::all();
        return view('admin.agents.create', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Agent::create([
            'user_id'     => $user->id,
            'hospital_id' => $data['hospital_id'],
        ]);

        return redirect()->route('admin.agents.index');
    }

    public function destroy(Agent $agent)
    {
        $agent->user()->delete();

        return redirect()->route('admin.agents.index');
    }
}