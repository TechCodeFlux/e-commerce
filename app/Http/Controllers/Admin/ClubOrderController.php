<?php

namespace App\Http\Controllers\admin;
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
    public function show(Request $request,$id)
    {
    // $clubid= Auth::guard('club')->user()->id;
    // club_member_id is hardcoded for now, replace with auth()->id() when authentication is implemented
     $club=Club::where('id',$id)->first();
    if ($request->ajax()) {
        
        $orders = Order::with('product', 'varient', 'clubmember', 'order_status','address')        
            ->where('club_id', $id)
            ->orderBy('order_status_id','asc');

            
            

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
                  return optional($row->address)->address1 ?? '--';
            })

            ->addColumn('size', fn ($row) => $row->varient->size ?? '--')
            ->addColumn('color', fn ($row) => $row->varient->color ?? '--')

            ->addColumn('order_status', function ($row) {
                    if(optional($row->order_status)->status == 'Confirmed'){
                        $row->order_status_id=$row->order_status_id + 1;
                        $row->save();
                        return optional($row->order_status)->status ?? '--';
                    }
                    return optional($row->order_status)->status ?? '--';
                })
     
            



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
        // dd("hyktc",'order_status_id');
        // dd("yguiui",'order_status');

    return view('admin.club.order_management.vieworder', compact('club'));
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
            $Order = Order::findOrFail($id);

            $currentStatus = $Order->order_status_id;

            // Allow update only if current status < 6
            if ($currentStatus < 6) {

                $newStatus = $currentStatus + 1;

                $Order->order_status_id = $newStatus;
                $Order->save();

                return redirect()->back()
                    ->with('success', 'Order status updated successfully.');

            } else {

                return redirect()->back()
                    ->with('error', 'Order is already in the final status.');
            }
        }
}
