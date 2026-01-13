<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;



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
    protected $redirectTo = 'dashboard';

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
    //  public function login(Request $request, User $user)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //    if($user->email === $credentials['email'] && $user->password === $credentials['password'])
    //     {
    //         return redirect()->route('admin.index',['credentials'=>$credentials]);

    //     }
    //     return back()->with('error', 'Invalid credentials');
    // }

    public function showLoginForm()
    {
    
        return view('auth.login');
    }
    protected function redirectTo()
    {
        return route('dashboard');
    }
 protected function guard()
    {
        return Auth::guard('web');
    }
public function logout(Request $request)
    {
        Auth::guard('web')->logout();
     }
}
