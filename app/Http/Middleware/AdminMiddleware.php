<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, ?string $permission = null)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('warning', 'Please sign in to access the Admin Control Center.');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your administrative account has been deactivated. Please contact support.');
        }

        if (!$user->isAdmin()) {
            return redirect()->route('admin.login')->with('error', 'Access denied. You must possess administrative privileges.');
        }

        if ($permission && !$user->hasPermission($permission)) {
            abort(403, "Access Denied: You do not possess the required permission [{$permission}].");
        }

        return $next($request);
    }
}
