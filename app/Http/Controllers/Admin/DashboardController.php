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
    
    public function club()
    {
        return view('admin.addclub');
    }
    public function store(Request $request)
    {
         $validated = $request->validate([
        'club_name'    => 'required|string|max:255',
        'club_address' => 'required|string',
        'club_contact' => 'required|string|max:20',
        'email'        => 'required|email|unique:clubs,email',
        'country_id'   => 'required|integer',
        'state_id'     => 'required|string|max:100',
        'city'         => 'required|string|max:100',
        'zip_code'     => 'required|string|max:10',
        'status'       => 'required',//'nullable',
    ]);

        $randomPassword = Str::random(10);

        Club::create([
            'name' => $request->club_name,
            'address' => $request->club_address,
            'contact' => $request->club_contact,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'status' => $request->has('status'),
            'password'    => Hash::make($randomPassword),
        ]);
        
        return redirect()->back()->with('success', 'Club registered successfully!');
    }
   
    // public function destroy(Club $club)
    // {
    //     $club->delete();

    //     return redirect()
    //         ->route('admin.club.index')
    //         ->with('success', 'Club deleted successfully.');
    // }

    // public function edit(Club $club)
    // {
    //     return view('admin.clubedit', compact('club'));
    // }


    // public function update(Request $request, Club $club)
    // {
    //     $request->validate([
    //         'club_name'    => 'required|string|max:255',
    //         'club_address' => 'required|string',
    //         'club_contact' => 'required|string|max:20',
    //         'email'        => 'required|email',
    //     ]);

    //     User::update([
    //         'name'       => $request->club_name,
    //         'address'    => $request->club_address,
    //         'contact'    => $request->club_contact,
    //         'email'      => $request->email,
    //         'country_id' => $request->country_id,
    //         'state_id'   => $request->state_id,
    //         'city'       => $request->city,
    //         'zip_code'   => $request->zip_code,
    //         'status'     => $request->has('status'),
    //     ]);

    //     return redirect()
    //         ->route('admin.club.index')
    //         ->with('success', 'Club updated successfully');
    // }
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