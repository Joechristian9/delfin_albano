<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JudgeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if authenticated user has role "judge"
        if (auth()->check() && auth()->user()->role === 'judge') {
            return $next($request);
        }

        // Otherwise, deny access
        abort(403, 'Access denied — Judges only.');
    }
}
