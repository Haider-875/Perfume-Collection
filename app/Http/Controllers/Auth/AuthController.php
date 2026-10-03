<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');
        $oldSessionId = $request->session()->getId();

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Merge guest cart items into user cart
            $this->cartService->mergeGuestCartOnLogin($oldSessionId, Auth::id());

            if ($request->session()->has('intended')) {
                return redirect()->intended();
            }

            return redirect()->route('account.dashboard')->with('success', 'Welcome back, ' . Auth::user()->name . '.');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'These credentials do not match our patron records.',
        ]);
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'regex:/^((\+92)|(0092)|(0))?3[0-9]{2}[0-9]{7}$/'],
            'city' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $oldSessionId = $request->session()->getId();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? 'Lahore',
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Merge guest cart into newly registered account
        $this->cartService->mergeGuestCartOnLogin($oldSessionId, $user->id);

        return redirect()->route('account.dashboard')->with('success', 'Your bespoke fragrance account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been safely signed out.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Safe status message
        return back()->with('status', 'If an account exists with this email address, a password reset link has been dispatched.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            Auth::login($user);
            return redirect()->route('account.dashboard')->with('success', 'Your password has been updated securely.');
        }

        return back()->withErrors(['email' => 'Unable to reset password for this email address.']);
    }
}
