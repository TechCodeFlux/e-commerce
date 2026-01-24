<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class Order extends Model
{
    use SoftDeletes;


public function orderHistory()
{
    // Fetch all orders for the logged-in user
    $orders = Order::with('items', 'status')
                   ->where('user_id', Auth::id()) // or 'club_member_id' if your column is different
                   ->orderBy('created_at', 'desc')
                   ->get();

    // Return the view
    return view('clubmember.orderhistory', compact('orders'));
}

}
