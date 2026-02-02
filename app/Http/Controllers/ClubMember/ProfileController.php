<?php

namespace App\Http\Controllers\ClubMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class ProfileController extends Controller
{
    // Show Edit Address Page
    public function edit()
    {
        // $user = auth()->user();
        $countries = Country::all();

        return view('clubmember.profile.edit-profile', compact('user', 'countries'));
    }

    // Update Address Only
    public function update(Request $request)
    {
        $request->validate([
            'address'  => 'required|string|max:500',
            'country'  => 'required|exists:countries,id',
            'state'    => 'required|exists:states,id',
            'city'     => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        // $user = auth()->user();

        // $user->update([
        //     'address'    => $request->address,
        //     'country_id' => $request->country,
        //     'state_id'   => $request->state,
        //     'city'       => $request->city,
        //     'zip_code'   => $request->zip_code,
        // ]);

        return back()->with('success', 'Address updated successfully.');
    }

    // Load states dynamically
    public function getStates($countryId)
    {
        return State::where('country_id', $countryId)->get();
    }
}
