<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use App\Models\ClubMember;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;


class ClubMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('club.clubmember.clubmemberview');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clubmember = new ClubMember();
        $countries = Country::orderBy('name')->get();
        return view('club.clubmember.form', compact('clubmember', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:club_members,email',
        'contact'   => 'required|string|max:20',
        'address1'  => 'required|string',
        'address2'  => 'nullable|string',
        'country'   => 'required|integer|exists:countries,id',
        'state'     => 'required|integer|exists:states,id',
        'city'      => 'required|string|max:100',
        'zip_code'  => 'required|string|max:10',
        'status'    => 'required|boolean',
    ]);

    $randomPassword = Str::random(8);

    DB::transaction(function () use ($validated, $randomPassword, $request) {

        $address = Address::create([
            'address1'   => $validated['address1'],
            'address2'   => $validated['address2'] ?? null,
            'country_id' => $validated['country'],
            'state_id'   => $validated['state'],
            'city'       => $validated['city'],
            'zip_code'   => $validated['zip_code'],
        ]);

        ClubMember::create([
            'name'       => $validated['name'],
            'address_id' => $address->id,
            'contact'    => $validated['contact'],
            'email'      => $validated['email'],
            'status'     => $request->boolean('status'),
            'password'   => Hash::make($randomPassword),
        ]);
    });

    return redirect()
        ->route('admin.clubmembersindex')
        ->with('success', 'Club member registered successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(ClubMember $clubMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClubMember $clubMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClubMember $clubMember)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubMember $clubMember)
    {
        //
    }
}
