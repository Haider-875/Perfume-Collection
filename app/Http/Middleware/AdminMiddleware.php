<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please authenticate with administrative privileges.');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden. Exclusive administrative access only.');
        }

        return $next($request);
    }
}
