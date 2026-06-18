<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function show() {
        if (Auth::user()->is_verified) {
            return redirect()->route('dashboard');
        }
        return view('auth.verify-email-code');
    }

    public function verify(Request $request) {
        $request->validate(['code' => 'required|string|size:6']);
        $user = Auth::user();

        if ($user->is_verified) return redirect()->route('dashboard');

        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Code incorrect.']);
        }
        if (now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'Code expiré.']);
        }

        $user->update(['is_verified' => true, 'verification_code' => null]);
        return redirect()->route('dashboard')->with('success', 'Compte activé !');
    }

    public function resend() {
        $user = Auth::user();
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);
        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));
        return back()->with('success', 'Nouveau code envoyé !');
    }
}