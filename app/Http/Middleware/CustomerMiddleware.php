<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'customer'])) {
            if ($request->is('b2b/*')) {
                return redirect(route('b2b-home'));
            }
            return redirect(route('home'));
        }

        return $next($request);
    }
}
