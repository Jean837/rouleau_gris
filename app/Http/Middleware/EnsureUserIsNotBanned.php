<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsNotBanned
{
    public function handle(Request $request, Closure $next) {
        if (Auth::check() && Auth::user()->is_banned) {
            $reason = Auth::user()->ban_reason;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('banned', $reason);
        }
        return $next($request);
    }
}