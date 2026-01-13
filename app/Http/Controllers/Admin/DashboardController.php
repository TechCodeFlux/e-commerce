<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function profile()
    {
        $user = Auth::guard('admin')->user();
        // dd(Auth::guard('admin')->user());
        return view('admin.profile', compact('user'));
    }
    public function profile_update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}
