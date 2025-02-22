<?php

namespace App\Http\Controllers\School\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\School;

class VerifyEmailController extends Controller
{
    public function verify(Request $request, $id, $hash): RedirectResponse
    {
        $school = School::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($school->getEmailForVerification()))) {
            return redirect()->route('School.login')->with('error', 'Invalid verification link.');
        }

        if ($school->hasVerifiedEmail()) {
            return redirect()->route('School.dashboard')->with('message', 'Email is already verified.');
        }

        $school->markEmailAsVerified();
        event(new Verified($school));

        Auth::guard('school')->login($school);

        return redirect()->route('School.dashboard')->with('message', 'Email verified successfully.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('School.dashboard')->with('message', 'Email is already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'A new verification link has been sent to your email.');
    }
}
