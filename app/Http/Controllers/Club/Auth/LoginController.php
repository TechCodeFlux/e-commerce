<?php

namespace App\Http\Controllers\Club\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // public function __construct()
    // {
    //     $this->middleware('guest:club')->except('logout');
    // }

    protected function guard()
    {
        return Auth::guard('club');
    }

    protected function redirectTo()
    {
        return '/club/dashboard';
    }

    public function showLoginForm()
    {
        return view('club.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('club')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/club/login');
    }
}
