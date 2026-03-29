<?php

namespace App\Http\Controllers\ClubMember\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
 use App\Models\Order;

class LoginController extends Controller
{
    // 🔹 Show Login Page
    public function showLoginForm()
    {
        return view('clubmember.auth.login');
    }

    // 🔹 Send OTP
    public function sendOtp(Request $request)
    {
        $member = DB::table('club_members')
            ->where('email', $request->email)
            ->first();

        if (!$member) {
            return back()->with('error', 'Email not found');
        }

        $otp = rand(100000, 999999);

        DB::table('club_members')
            ->where('email', $request->email)
            ->update(['otp' => $otp]);

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Login OTP');
        });

        session(['otp_email' => $request->email]);

        return back()->with('success', 'OTP sent to your email');
    }

    // 🔹 Verify OTP + Login
    public function verifyOtp(Request $request)
    {
        $member = DB::table('club_members')
            ->where('email', session('otp_email'))
            ->where('otp', $request->otp)
            ->first();

        if (!$member) {
            return back()->with('error', 'Invalid OTP');
        }

        // Login
        Auth::guard('clubmember')->loginUsingId($member->id);

        // Clear OTP
        DB::table('club_members')
            ->where('id', $member->id)
            ->update(['otp' => null]);

        return redirect()->route('clubmember.dashboard');
    }

    // 🔹 Dashboard
public function dashboard()
{
    $member = Auth::guard('clubmember')->user();

    if (!$member) {
        return redirect()->route('clubmember.login');
    }

    // ✅ FIXED COLUMN NAME
    $orders = Order::with('items')
        ->where('club_member_id', $member->id)
        ->get();

    return view('clubmember.dashboard', compact('member', 'orders'));
}
    // 🔹 Logout
    public function logout()
    {
        Auth::guard('clubmember')->logout();
        return redirect()->route('clubmember.login');
    }
}