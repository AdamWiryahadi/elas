<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not logged in
        }

        if (Auth::user()->role !== 'admin') {
            abort(403); // Show 403 Forbidden if not an admin
        }

        return $next($request);
    }

}

