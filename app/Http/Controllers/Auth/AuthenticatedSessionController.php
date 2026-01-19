<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form (for CMS / fallback).
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request (supports both web + AJAX).
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            // ✅ If the request came from AJAX (popup form)
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                ]);
            }

            // ✅ If normal login (CMS)
            return redirect()->intended(route('dashboard'));
        } catch (\Throwable $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password',
                ], 401);
            }

            return back()->withErrors([
                'email' => 'Invalid credentials provided.',
            ]);
        }
    }

    /**
     * Log out the user.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect('/');
    }
}
