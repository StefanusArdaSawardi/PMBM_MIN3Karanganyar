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

        if (Auth::guard($guard)->attempt($authData)) {
            $request->session()->regenerate();
            
            if ($guard === 'tata_usaha') {
                return redirect()->route('tata_usaha.dashboard');
            }
            return redirect()->route('panitia.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Kata Sandi salah untuk hak akses yang dipilih.',
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
