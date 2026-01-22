<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;
use App\Models\Club;
use App\Models\Admin;


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

        $validate=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $validate['name'];
        $user->email = $validate['email'];
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
    
    public function store(Request $request)
    {
         //
    }
   
    // public function destroy(Club $club)
    // {
    //     $club->delete();

    //     return redirect()
    //         ->route('admin.club.index')
    //         ->with('success', 'Club deleted successfully.');
    // }

    public function edit(Club $club)
    {
        //
    }


    public function update(Request $request, Club $club)
    {
        //
    }
//aishwarya
    // public function addnew()
    // {
    //     return view('admin.admin');
    // }

    // public function storeadmin(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name'    => 'required|string|max:255',
    //         'email'   => 'required|email|unique:users,email',
    //         'dob'     => 'required|date',
    //         'gender'  => 'required|in:Male,Female,Other',
    //         'address' => 'required|string',
    //         'contact' => 'required|string|max:15',
    //     ]);

    //     return redirect()
    //         ->route('admin.addadmin.create')
    //         ->with('success', 'Admin added successfully!');
    // }

}
