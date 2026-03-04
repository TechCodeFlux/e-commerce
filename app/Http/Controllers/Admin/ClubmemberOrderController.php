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
                'product',
                'varient',
                'clubMember',
                'order_status'
            ])
            ->where('club_member_id', $id)
            ->get()
            ->map(function ($order) {
                return [
                    'name' => optional($order->product)->name ?? 'N/A',
                    'image' => $order->product && $order->product->image
                          ? asset('storage/' . $order->product->image)
                            : asset('images/no-image.png'),
                    'size' => optional($order->varient)->size ?? 'N/A',
                    'color' => optional($order->varient)->color ?? 'N/A',
                    'stock' => optional($order->product)->stock ?? 0,

                    'username' => optional($order->clubMember)->name ?? 'User',
                    'email' => optional($order->clubMember)->email ?? 'N/A',
                    'phone' => optional($order->clubMember)->contact ?? 'N/A',

                    'order_status' => optional($order->order_status)->status ?? 'Pending',

                    'quantity' => $order->quantity ?? 1,
                    'created_at' => $order->created_at,

                    'action' => optional($order->order_status)->status == "Out for delivery"
                                    ? '<div>
                                        <a href="'. route('admin.clubmember.orderstatus',$order->id).'" class="btn btn-sm btn-clean btn-icon" title="delivered">
                                                        <i class="btn btn-sm btn-danger"> Conform delivery</i> 
                                        </a>
                                    </div>'
                                    : ''            
                                      
                ];
            });

            return response()->json(['data' => $orders]);
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