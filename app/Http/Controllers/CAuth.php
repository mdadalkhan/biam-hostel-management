<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CAuth extends Controller {
    
    public function ViewLogin() {
        if(Auth::check()) {
            return redirect()->intended('dashboard');
        } else {
            return view('welcome');
        } 
    }

    public function login(Request $req) {
        $auth = $req->validate([
           'email'    => ['required', 'email'],
           'password' => ['required']
        ]);

        $rem = $req->has('remember');

        if(Auth::attempt($auth, $rem)) {
            $req->session()->regenerate();
            return redirect()->intended('dashboard');
        } 

        return back()->withErrors([
            'email' => 'Authentication fail! try again',
        ])->onlyInput('email');
    }

    public function Logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}