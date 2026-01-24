<?php

namespace App\Http\Controllers;

use App\Models\ClubMember;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     * Example: all club members (optional)
     */
    public function index()
    {
        $members = ClubMember::all();
        return view('clubmember.index', compact('members'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
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
        return view('clubmember.show', compact('clubMember'));
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

    /**
     * Display the logged-in member's order history.
     */

// public function orderHistory()
// {
//     // Fetch orders for the logged-in user
//     $orders = Order::with('items', 'status')
//                    ->where('user_id', Auth::id()) // adjust if your column is different
//                    ->orderBy('created_at', 'desc')
//                    ->get();

//     // Return the view
//     return view('clubmember.orderhistory', compact('orders'));
// }

}
