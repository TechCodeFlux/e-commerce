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
        $clubs = Club::all();
        return view('clublist', compact('clubs'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('club'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Club::create([
            'name' => $request->club_name,
            'address' => $request->club_address,
            'contact' => $request->club_contact,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Club registered successfully!');
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
        $club->update([
        'name' => $request->club_name,
        'address' => $request->club_address,
        'contact' => $request->club_contact,
        'username' => $request->username,
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
