<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\EmailHelper;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json(['redirect' => route('admin.dashboard')]);
            }
            return redirect()->route('admin.dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'The provided credentials do not match our records or you are not an admin.'], 422);
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not an admin.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // New registered users are not admins by default
        ]);

        // Send welcome email
        EmailHelper::sendDynamicEmail(
            'user_welcome',
            $user->email,
            [
                'user_name' => $user->name,
                'app_name' => config('app.name'),
                'login_link' => route('admin.login')
            ]
        );

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please log in.');
    }
}