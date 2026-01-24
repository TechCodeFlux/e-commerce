<?php

namespace App\Http\Controllers\ClubMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// If you have an Order model
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the club member's orders.
     */
    public function index()
    {
        // Get the logged-in club member
        $clubMember = Auth::guard('clubmember')->user();

        // Fetch their orders (example, assuming Order has club_member_id)
        $orders = Order::where('club_member_id', $clubMember->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Return a Blade view (we’ll create this next)
        return view('clubmember.orders.index', compact('orders'));
    }
}
