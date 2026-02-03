<?php
/**
 * @author: MD. ADAL KAHN 
 * <mdadalkhan@gmail.com>
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CAuth extends Controller 
{
    /**
     * Show the feedback/welcome page.
     */
    public function feedback(): View 
    {
        return view('welcome');
    }

    /**
     * Show the login form, or redirect if already authenticated.
     */
    public function viewLogin(): View | RedirectResponse 
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        } 
        return view('Login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse 
    {
        $credentials = $request->validate([
           'email'    => ['required', 'email'],
           'password' => ['required']
        ]);

        /**
         * Adal Khan
         * $request->has('remember') use this in the seconde arguments if remembered me featured is required.
         * also remember me form control need to be enabled in login.blade.php
         * 
         * */ 
        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        } 

        return back()->withErrors([
            'email' => 'Authentication fail! try again',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->intended(route('welcome'));
    }
}