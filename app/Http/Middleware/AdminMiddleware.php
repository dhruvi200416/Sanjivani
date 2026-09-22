<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user_role') !== 'admin') {
            return redirect('/')->with('error', 'Access denied. Administrator privileges required.');
        }

        return $next($request);
    }
}