<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
{
    if (session('user_role') !== 'delivery') {
        return redirect('/')->with('error', 'Access denied. Delivery partner account required.');
    }

    // ❌ Old code:
    // $partner = \App\Models\DeliveryPartner::where('user_id', session('user_id'))->first();

    // ✅ New code:
    $partner = \App\Models\DeliveryPartner::find(session('user_id'));

    if (!$partner || $partner->status !== 'active') {
        session()->flush();
        return redirect('/login')->with('login_error', 'Your delivery partner account is pending administrator approval.');
    }

    return $next($request);
}
}