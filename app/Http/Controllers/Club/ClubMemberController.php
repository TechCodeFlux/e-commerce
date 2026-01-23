<?php
namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\ClubMember;
use Illuminate\Http\Request;

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
        return view('club.clubmember.form', compact('clubmember'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubMember $clubMember)
    {
        //
    }
}
