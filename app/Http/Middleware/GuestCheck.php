<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user_id') && session()->has('user_role')) {
            $role = session('user_role');
            
            $redirectUrl = match ($role) {
                'admin'    => '/admin/dashboard',
                'customer' => '/customer/dashboard',
                'pharmacy' => '/pharmacy/dashboard',
                'delivery' => '/delivery/dashboard',
                default    => '/',
            };

            return redirect($redirectUrl);
        }

        return $next($request);
    }
}