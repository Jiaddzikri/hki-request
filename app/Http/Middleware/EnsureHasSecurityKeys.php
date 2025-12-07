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
        if ($user && empty($user->public_key)) {
            if (!$request->routeIs('setup.security')) {
                return redirect()->route('setup.security');
            }
        }
        if ($user && !empty($user->public_key) && $request->routeIs('setup.security')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}