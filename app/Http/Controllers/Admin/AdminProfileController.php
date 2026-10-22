<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Display the authenticated Administrator's profile & security settings
     */
    public function index()
    {
        $user = Auth::user();
        $recentLogs = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(8)
            ->get();

        return view('admin.profile.index', compact('user', 'recentLogs'));
    }

    /**
     * Update Administrator Password with security hardening
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers(),
                'confirmed',
                'different:current_password'
            ],
        ], [
            'current_password.current_password' => 'The provided current password does not match your administrative credentials.',
            'password.different' => 'Your new password cannot be the same as your current password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Your new password must be at least 8 characters and include letters and numbers.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Regenerate session for security
        $request->session()->regenerate();

        ActivityLog::record('admin_password_changed', "Administrator [{$user->name}] updated their credentials", $user);

        return back()->with('success', 'Your administrative password has been updated successfully.');
    }

    /**
     * Update Administrator Profile Details
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $user->name = $validated['name'];
        $user->email = strtolower(trim($validated['email']));
        $user->phone = $validated['phone'];
        $user->city = $validated['city'];
        $user->save();

        ActivityLog::record('admin_profile_updated', "Updated profile details for [{$user->name}]", $user);

        return back()->with('success', 'Your administrator profile details have been updated.');
    }
}
