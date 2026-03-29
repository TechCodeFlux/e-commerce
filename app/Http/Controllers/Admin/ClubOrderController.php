<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use App\Models\Order;
// use App\Models\OrderItem;
// use App\Models\Product;
// use App\Models\Cart;
// use App\Models\Address;
// use App\Models\ClubMember;
// use App\Models\Varient;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubOrderController extends Controller
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
    public function show(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $orders = Order::with(['items.product', 'items.variant']) // load all variants/products
            ->where('club_id', $id)
            ->latest()
            ->get();

        return view('admin.club.order_management.vieworder', compact('club', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
        public function changestatus(Request $request, $id)
        {
            $order = Order::findOrFail($id);

            $order->order_status_id = 7;
            $order->order_status = 'Completed'; // optional if you store text
            $order->save();

            return redirect()->back()->with('success', 'Order marked as completed');
        }
}