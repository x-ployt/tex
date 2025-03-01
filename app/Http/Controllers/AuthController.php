<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Redirect to the dashboard.
     */
    public function dashboard()
    {
        return view('app');
    }

    /**
     * Handle user password change.
     */
    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'currentPassword' => ['required', 'string', 'current_password'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->newPassword), // Hash the new password
        ]);

        return redirect()->back()->with('changeSuccess', 'Password changed successfully.');
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        Session::flush(); // Clear session
        Auth::logout();
        Session::invalidate(); // Invalidate session
        Session::regenerateToken(); // Regenerate CSRF token

        return redirect()->route('login');
    }
}
