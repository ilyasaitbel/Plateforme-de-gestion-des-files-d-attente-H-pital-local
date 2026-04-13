<?php

namespace App\Http\Controllers;

use App\Models\Administrator;

class AdministratorController extends Controller
{
    public function index()
    {
        $administrators = Administrator::with('user')->get();
        return view('administrators', compact('administrators'));
    }

    public function show(Administrator $administrator)
    {
        $administrator->load('user');
        return view('administrators.show', compact('administrator'));
    }
}