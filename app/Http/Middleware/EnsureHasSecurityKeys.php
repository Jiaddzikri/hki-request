<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasSecurityKeys
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user && ! $user->webAuthnCredentials()->exists()) {
            if (! $request->routeIs('setup.security') && ! $request->routeIs('biometric.recovery')) {
                return redirect()->route('setup.security');
            }
        }
        if ($user && $user->webAuthnCredentials()->exists() && $request->routeIs('setup.security')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
