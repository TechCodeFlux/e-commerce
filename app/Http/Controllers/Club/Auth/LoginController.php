<?php

namespace App\Http\Controllers\Club\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
         $request->session()->forget('guard_club');
         $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
           // return $response;
            return redirect()->route('club.login');  
            
            }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('club.dashboard');
        

    }
  
    protected function authenticated(Request $request)
    {
        // $users = User::find($user['id']);
        // dd($users);
        // if ($user->status == 0 || $users->status == 0) {
        //     $this->guard()->logout();
        //     return view('admin.auth.login');
        // }
    
        return redirect()->intended($this->redirectTo());
    }
}

    
