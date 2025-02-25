<?php

namespace App\Http\Controllers\School\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('School.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('school')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('school')->user();

            if (!$request->user()->hasVerifiedEmail() && $request->bypass_verify_email != 'on') {
                Auth::guard('school')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Your email is not verified. Please check your inbox.',
                ]);
            }

            return redirect()->route('School.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('school')->logout();

        // $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('School.login');
    }
}
