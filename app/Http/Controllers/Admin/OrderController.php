<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Club;

class OrderController extends Controller
{
    public function index(Club $club)
    {
        $orders = Order::where('club_id', $club->id)
                        ->latest()
                        ->get();

        return view('admin.club.orders', compact('orders', 'club'));
    }
}