<?php

namespace App\Http\Controllers\Club\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Club;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('club.auth.login');
    }

    /**
     * Login
     */
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::guard('club')->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        // login success
        return redirect()->route('club.dashboard');
    }

    return back()->with('error', 'Invalid credentials');
}
    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('club')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('club.login');
    }
}