<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PharmacyMiddleware
{
    /**
     * Handle an incoming request.
     */
  public function handle(Request $request, Closure $next): Response
{
    if (session('user_role') !== 'pharmacy') {
        return redirect('/')->with('error', 'Access denied. Pharmacy partner account required.');
    }

    // 🔁 Change this line:
    // $pharmacy = \App\Models\Pharmacy::where('user_id', session('user_id'))->first();
    // To:
    $pharmacy = \App\Models\Pharmacy::find(session('pharmacy_id'));

    if (!$pharmacy || $pharmacy->status !== 'active') {
        session()->flush();
        return redirect('/login')->with('login_error', 'Your pharmacy account is pending administrator approval.');
    }

    return $next($request);
}
}