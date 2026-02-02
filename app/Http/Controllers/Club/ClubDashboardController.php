<?php

namespace App\Http\Controllers\Club;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;


class ClubDashboardController extends Controller
{
    public function index()
    {
        return view('club.dashboard');
    }
    public function vieworder(Request $request)
    {
    $clubid = 1;
    $memberId = 1;

    if ($request->ajax()) {

        $orders = Order::with(['product', 'clubmember', 'address'])
                // ->where('order_status_id', 1)
                ->where('club_id', $clubid)
                ->where('club_member_id', $memberId);

       return datatables()
            ->eloquent($orders)
            ->addColumn('name', fn ($row) => $row->product->name ?? '--')
            ->addColumn('description', fn ($row) => $row->product->description ?? '--')
            ->addColumn('quantity', fn ($row) => $row->quantity ?? 0)
            ->addColumn('stock', fn ($row) => $row->product->stock ?? 0)
            ->addColumn('image', function ($row) {
                return $row->product && $row->product->image
                    ? '<img src="'.asset('storage/'.$row->product->image).'" width="60">'
                    : '--';
            })
            ->addColumn('username', fn ($row) => $row->clubmember->name ?? '--')
            ->addColumn('address', fn ($row) => $row->address->address1 ?? '--')
            ->addColumn('email', fn ($row) => $row->clubmember->email ?? '--')
            ->addColumn('phone', fn ($row) => $row->clubmember->contact ?? '--')
            ->addColumn('created_at', fn ($row) => $row->created_at->format('d-m-Y'))
            ->addColumn('order_status_id', fn ($row) => $row->order_status_id)
            ->addColumn('username', fn ($row) => $row->clubmember->name ?? '--')

            // ->addColumn('action', function ($row) {
            //     return '
            //     <a href="#" class="btn btn-sm">
            //         <i class="fas fa-shopping-cart text-success"></i>
            //     </a>

            //     // <a href="'.route('clubmember.booking', $row->product_id).'" class="btn btn-sm">
            //     //     <i class="fas fa-credit-card"></i>
            //     // </a>';
            // })

            //toggle button
            ->addColumn('status', function (Order $order) {

                return '
                 <span
                         id="status-label-'.$order->id.'" 
                          class=" '.( $order->order_status_id ==2 ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ).' ">
                            '.($order->order_status_id == 1 ? 'not confirmed' : ' confirmed ' ).'
                 </span>
                       
                        <div class="form-check form-switch">
                                     <input 
                                          class="form-check-input toggle-status"
                                          type="checkbox"
                                          name="status"
                                          data-id="'.$order->id.'"  '.($order->order_status_id !=1 ? 'checked' : '').'>
                         </div>';
            })

            ->rawColumns(['image','status'])
            ->make(true);
            }

    return view('club.order.vieworder');
    }

//toggle button

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->id);
        if ($order) {
            $order->order_status_id = $request->order_status_id;
            $order->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'order not found.'], 404);
    }
    //end toggle button
}
