<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan role
        $role = $request->user()->usertype;

        if ($role === 'admin') {
            return redirect()->intended('/admin/dashboard')->with('success', 'Login Berhasil!');
        } elseif ($role === 'user') {
            return redirect()->intended('/dashboard')->with('success', 'Login Berhasil!');
        } elseif ($role === 'dosen') {
            return redirect()->intended('/dosen/dashboard')->with('success', 'Login Berhasil!');
        } elseif ($role === 'tendik') {
            return redirect()->intended('/tendik/dashboard')->with('success', 'Login Berhasil!');
        }

        // Default jika tidak ada role
        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
