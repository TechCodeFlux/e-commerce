<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.club');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Club::create([
        'name'       => $request->name,
        'contact'    => $request->contact,
        'address'    => $request->address,
        'country_id' => $request->country_id,
        'state_id'   => $request->state_id,
        'city'       => $request->city,
        'zip_code'   => $request->zip_code,
        'status'     => 1,
        'password'   => Hash::make($request->password),
    ]);
       return redirect()
        ->route('admin.club.create')
        ->with('success', 'Club added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        return view('clubedit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $request->validate([
        'club_name' => 'required|string|max:255',
        'club_address' => 'required|string',
        'club_contact' => 'required|string',
        'email' => 'required|email|unique:clubs,email,' . $club->id,
        'country_id' => 'required|integer',
        'state_id' => 'required|integer',
        'city' => 'required|string',
        'zip_code' => 'required|string',
        'status' => 'required|in:active,inactive',
    ]);
        $club->update([
        'name' => $request->club_name,
        'address' => $request->club_address,
        'contact' => $request->club_contact,
        'email' => $request->email,
        'country_id' => $request->country_id,
        'state_id' => $request->state_id,
        'city' => $request->city,
        'zip_code' => $request->zip_code,
        'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $club->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('club.index')
            ->with('success', 'Club updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()
            ->route('club.index')
            ->with('success', 'Club deleted successfully.');
    }
}
