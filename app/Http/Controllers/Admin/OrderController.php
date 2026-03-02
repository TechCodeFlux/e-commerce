<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Club;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request, $club)
    {
        if ($request->ajax()) {

            $orders = Order::with(['product','member','status'])
                ->where('club_id', $club);

            return DataTables::of($orders)

                ->addColumn('product_name', function ($row) {
                    return $row->product->name ?? '-';
                })

                ->addColumn('member_name', function ($row) {
                    return $row->member->name ?? '-';
                })

                ->addColumn('status_name', function ($row) {
                    return $row->status->name ?? '-';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button class="btn btn-sm btn-primary view-order"
                            data-id="'.$row->id.'"
                            data-quantity="'.$row->quantity.'"
                            data-product="'.($row->product->name ?? '-').'"
                            data-member="'.($row->member->name ?? '-').'"
                            data-status="'.($row->status->name ?? '-').'"
                            data-date="'.$row->created_at.'">
                            View
                        </button>

                        <button class="btn btn-sm btn-danger delete-order"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        $club = Club::findOrFail($club);

        return view('admin.club.orders', compact('club'));
    }


    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}