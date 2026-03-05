<?php

namespace App\Http\Controllers\Club;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Address;
use App\Models\ClubMember;
use App\Models\Varient;
use Illuminate\Http\Request;

class ClubOrderControllers extends Controller
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
    public function show(Request $request)
    {
    $clubid= Auth::guard('club')->user()->id;
    // club_member_id is hardcoded for now, replace with auth()->id() when authentication is implemented

    if ($request->ajax()) {
        
        $orders = Order::with('product', 'varient', 'clubmember', 'order_status')        
            ->where('club_id', $clubid);
            // ->where('club_member_id', $clubmemberId); 

        return datatables()
            ->eloquent($orders)

            ->addColumn('name', fn ($row) => $row->product->name ?? '--')

            ->addColumn('description', fn ($row) => $row->product->description ?? '--')

            ->addColumn('stock', fn ($row) => $row->varient->stock ?? 0)
            ->editColumn('created_at', fn($m) => $m->created_at->format('d M Y'))

            //->addColumn('quantity', fn ($row) => $row->order->quantity )

            ->addColumn('image', function ($row) {
                if ($row->product && $row->product->image) {
                    return asset('storage/' . $row->product->image);
                }
                return '<span class="text-muted">No Image</span>';
                })

            ->addColumn('username', fn ($row) => $row->clubmember->name ?? '--')
            ->addColumn('email', fn ($row) => $row->clubmember->email ?? '--')
            ->addColumn('phone', fn ($row) => $row->clubmember->contact ?? '--')

            ->addColumn('address', function ($row) {
                  return optional($row->clubmember->address)->address1 ?? '--';
            })

            ->addColumn('size', fn ($row) => $row->varient->size ?? '--')
            ->addColumn('color', fn ($row) => $row->varient->color ?? '--')

            ->addColumn('order_status', fn ($row) => optional($row->order_status)->status ?? '--')
            ->addColumn('action', function ($row) {

                $nextstatus = OrderStatus::where('id', '>', $row->order_status_id)
                                ->orderBy('id', 'asc')
                                ->first();

                if (!$nextstatus) {
                    return '<span class="badge bg-success">Completed</span>';
                }
                return optional($row->order_status)->id < 6 
                ?
                
                ' <form action="' . route('admin.clubs.changestatus', $row->id) . '" 
                        method="POST" 
                        class="d-inline">
                        
                        ' . csrf_field() . '
                        
                        <button type="submit" class="btn btn-sm btn-warning">
                            ' . $nextstatus->status . '
                        </button>
                    </form>
                ':'' ;
                
            })
            ->rawColumns(['image','action','order_status'])
            ->make(true);
    }

    return view('club.order.vieworder');
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
}
