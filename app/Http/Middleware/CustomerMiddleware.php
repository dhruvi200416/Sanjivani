<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user_role') !== 'customer') {
            return redirect('/')->with('error', 'Access denied. Customer account required.');
        }

        return $next($request);
    }
}