<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next) {
        if (auth()->check() && !auth()->user()->is_verified) {
            return redirect()->route('verify.email.form');
        }
        return $next($request);
    }
}