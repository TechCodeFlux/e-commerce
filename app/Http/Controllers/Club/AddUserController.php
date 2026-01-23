<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;

class ClubUserController extends Controller
{
    public function create()
    {
        $countries = Country::all(); // for dropdown
        $clubuser = new User(); // empty user for form (or ClubUser model)
        return view('club.adduser', compact('clubuser', 'countries'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'role'    => 'required|in:Staff,Manager,Volunteer,Coordinator,Member',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|exists:countries,id',
            'state'   => 'nullable|exists:states,id',
            'city'    => 'nullable|string|max:255',
            'zip_code'=> 'nullable|string|max:20',
        ]);

        $user = new User();
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->role      = $request->role;
        $user->contact   = $request->contact;
        $user->address   = $request->address;
        $user->country_id = $request->country;
        $user->state_id   = $request->state;
        $user->city      = $request->city;
        $user->zip_code  = $request->zip_code;
        $user->password  = bcrypt('password'); // default password or generate
        $user->save();

        return redirect()->route('club.adduser')->with('success', 'User added successfully!');
    }
}
