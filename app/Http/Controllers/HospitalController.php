<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        $user = Auth::user();
        $admin = $user?->administrator;

        if ($admin && $admin->hospital_id) {
            return redirect()->route('dashboard');
        }

        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $hospital = Hospital::create($data);

        $user = Auth::user();
        $admin = $user?->administrator;

        if (!$admin) {
            \App\Models\Administrator::create([
                'user_id' => $user->id,
                'hospital_id' => $hospital->id
            ]);
        } else {
            $admin->hospital_id = $hospital->id;
            $admin->save();
        }

        return redirect()->route('dashboard');
    }
}
