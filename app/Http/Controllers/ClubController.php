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
        return view('club');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Club::create([
            'name' => $request->name,
            'address'   => $request->address,
            'contact'   => $request->contact,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
        ]);
        return redirect()->back()->with('success', 'Inserted');
        
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
    public function edit( $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        //
    }
}
