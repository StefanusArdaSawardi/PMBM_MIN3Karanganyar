<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login portal.
     */
    public function showLoginForm()
    {
        if (Auth::guard('tata_usaha')->check()) {
            return redirect()->route('tata_usaha.dashboard');
        }
        if (Auth::guard('panitia')->check()) {
            return redirect()->route('panitia.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:tata_usaha,panitia'
        ]);

        $guard = $credentials['role'];
        $authData = [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ];

        // 1. Try selected guard first
        if (Auth::guard($guard)->attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->route($guard === 'tata_usaha' ? 'tata_usaha.dashboard' : 'panitia.dashboard');
        }

        // 2. Fallback: Try the alternative guard if email belongs to other table
        $fallbackGuard = ($guard === 'tata_usaha') ? 'panitia' : 'tata_usaha';
        if (Auth::guard($fallbackGuard)->attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->route($fallbackGuard === 'tata_usaha' ? 'tata_usaha.dashboard' : 'panitia.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Kata Sandi salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        if (Auth::guard('tata_usaha')->check()) {
            Auth::guard('tata_usaha')->logout();
        }
        if (Auth::guard('panitia')->check()) {
            Auth::guard('panitia')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
