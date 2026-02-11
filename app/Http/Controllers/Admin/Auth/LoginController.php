<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\jsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


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
    protected $redirectTo = 'admin/dashboard';

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
        
        return view('admin.auth.login');
    }
    protected function redirectTo()
    {
        // $user = Auth::user(); // current logged-in user
        // return '/'; 
        return route('admin.dashboard');
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
         $request->session()->forget('guard_admin');
         $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            // return $response;
            return redirect()->route('admin.login');  
            
            }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('admin.dashboard');
        

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
