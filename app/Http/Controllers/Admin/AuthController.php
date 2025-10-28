<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ===== Show login form =====
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // ===== Handle login =====
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ Check if user is admin (Spatie role check)
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            // ❌ If not admin, logout and block
            Auth::logout();
            return back()->withErrors(['access' => 'You are not authorized as admin.']);
        }

        return back()->withErrors(['login' => 'Invalid email or password.']);
    }

    // ===== Handle logout =====
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
