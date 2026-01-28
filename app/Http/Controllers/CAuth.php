<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CAuth extends Controller {
    
    public function feedback() {
        return view('welcome');
    }

    public function viewLogin() {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        } 
        return view('Login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
           'email'    => ['required', 'email'],
           'password' => ['required']
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        } 

        return back()->withErrors([
            'email' => 'Authentication fail! try again',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended(route('welcome'));
    }
}