<?php

namespace App\Http\Controllers\Club\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = 'club/dashboard';

    /**
     * Show the club login form
     */
    public function showLoginForm()
    {
        return view('club.auth.login');
    }

    /**
     * Redirect after login
     */
    protected function redirectTo()
    {
        return route('club.dashboard');
    }

    /**
     * Use club guard
     */
    protected function guard()
    {
        return Auth::guard('club');
    }

    /**
     * Logout club user
     */
    public function logout(Request $request)
    {
        Auth::guard('club')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('club.login');
    }
}
