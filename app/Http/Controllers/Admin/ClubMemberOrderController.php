<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubMember;
use App\Models\Club;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class ClubMemberOrderController extends Controller
{
    public function show($id)
{
    $clubmember = ClubMember::findOrFail($id);
    $club = Club::findOrFail($clubmember->club_id);

    if (request()->ajax()) {

        $orders = Order::with([
                'orderItems.variant',
                'orderItems.product',
                'address'
            ])
            ->where('club_member_id', $id)
            ->latest()
            ->get();

        $data = [];

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {

                $variant = $item->variant;
                $imagePath = optional($variant)->image;
                $address = $order->address;

                $fullAddress = $address
                    ? trim(
                        ($address->address1 ?? '') . ' ' .
                        ($address->address2 ?? '') . ', ' .
                        ($address->city ?? '') . ' - ' .
                        ($address->zip_code ?? '')
                    )
                    : 'N/A';

                $data[] = [
                    'name' => $item->product->name ?? 'Product',

                    // ✅ CORRECT IMAGE PATH
                    'image' => $imagePath
                        ? asset('storage/' . $imagePath)
                        : asset('images/no-image.png'),

                    'size' => $variant->size ?? 'N/A',
                    'color' => $variant->color ?? 'N/A',

                    'username' => $clubmember->name,
                    'email' => $clubmember->email,
                    'phone' => $clubmember->phone,

                    'address' => $fullAddress,

                    'quantity' => $item->quantity,
                    'stock' => $variant->stock ?? 0,

                    'order_status' => $order->order_status,
                    'created_at' => $order->created_at,
                ];
            }
        }

        return response()->json(['data' => $data]);
    }

    return view('admin.clubmember.vieworder', compact('clubmember', 'club'));
}

    public function update($id)
    {
        $order=Order::findorfail($id);
        $orderstatus=OrderStatus::findorfail($order->order_status_id);
        $clubmember = ClubMember::findOrFail($order->club_member_id);
        // dd($clubmember);
        $club = Club::findOrFail($clubmember->club_id);
        // dd($orderstatus);
        if($orderstatus->status== "Out for delivery")
            {
                $order->order_status_id = $order->order_status_id + 1;
                $order->save();
            }
        // return view('admin.clubmember.vieworder', compact('clubmember', 'club'));
        return redirect()
                ->route('admin.clubmember.vieworder', $clubmember->id)
                ->with('success', ' thank for buying product');
        
    }
}