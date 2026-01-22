<?php

namespace App\Http\Controllers\Clubmember\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{ 
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'clubmember/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('auth')->only('logout');
    // }
    public function showLoginForm()
    {

        return view('clubmember.auth.login');
    }
    protected function redirectTo() 
    {
        return route('clubmember.dashboard');
    }
    protected function guard()
    {
        return Auth::guard('clubmember');
    }
    public function logout(Request $request)
    {
        Auth::guard('clubmember')->logout();
    }
}
