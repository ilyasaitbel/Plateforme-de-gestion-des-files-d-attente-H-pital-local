<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Citoyen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('welcome', ['authMode' => 'register']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (User::count() === 1) {
            Administrator::create([
                'user_id' => $user->id,
            ]);
        } else {
            Citoyen::create([
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function showLogin()
    {
        return view('welcome', ['authMode' => 'login']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->with('error', 'Invalid credentials')
                ->with('authMode', 'login');
        }

        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}