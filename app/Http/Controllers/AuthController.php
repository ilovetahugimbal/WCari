<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('landing');
        }

        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing');
    }

    public function index() {
        $toilets = \App\Models\Toilet::all();
        // ...proses fasilitas, akses, rating, dst...
        return view('layouts.app', compact('toilets'));
    }
}