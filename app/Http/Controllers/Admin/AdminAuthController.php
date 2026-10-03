<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the dedicated Admin Login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('account.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Process Admin Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verify active status
            if (!$user->is_active) {
                Auth::logout();
                return back()->withInput($request->only('email', 'remember'))->withErrors([
                    'email' => 'Your administrative account has been deactivated. Please contact support.',
                ]);
            }

            // Verify admin privileges
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withInput($request->only('email', 'remember'))->withErrors([
                    'email' => 'Access denied. You must possess administrative privileges to enter the Admin Panel.',
                ]);
            }

            $request->session()->regenerate();

            if ($request->session()->has('intended')) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '.');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'Invalid administrator credentials. Please check your email and password.',
        ]);
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been safely logged out of the Admin Panel.');
    }
}
