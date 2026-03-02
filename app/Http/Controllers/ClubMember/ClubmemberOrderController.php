<?php

namespace App\Http\Controllers\ClubMember;
use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Address;
use App\Models\ClubMember;
use App\Models\Varient;
use Illuminate\Http\Request;


class ClubmemberOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $clubid = 1;
    $clubmemberId = 1; // club_member_id is hardcoded for now, replace with auth()->id() when authentication is implemented

    if ($request->ajax()) {
        
        $orders = Order::with('product', 'varient', 'clubmember', 'order_status')
            // ->where('order_status_id', 1)
            ->where('club_id', $clubid)
            ->where('club_member_id', $clubmemberId); 

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
            ->rawColumns(['image','action','order_status'])
            ->make(true);
    }

    return view('clubmember.product.vieworder');
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
        
        $request->validate([
                'quantity' => 'required',
                'email'    => 'required|email',
                'phone'    => 'required|digits:10',
            ]);

            // Insert into orders table
            $order = Order::create([
                    'quantity'        => $request->quantity,
                    'product_id'      => $variant->product_id,
                    'club_member_id'  => $request->clubmember_id,
                    'club_id'         => $request->club_id,
                    'varient_id'      => $variant->id,
                    'order_status_id' => 1,
                    'microsite_id'    => 1,
                ]);

            OrderItem::create([
                'quantity'     => $request->quantity,
                'order_id'     => $order->id,
                'microsite_id' => $order->microsite_id,
                'product_id'   => $request->product_id,
                'status'       => $order->order_status_id,
            ]);

            return redirect()
                ->route('clubmember.viewproduct')
                ->with('success', 'Order added to cart successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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

    public function cartorder($id)
   {
        $clubmemberId = 1; // club_member_id is hardcoded for now, replace with auth()->id() when authentication is implemented 
        $product = Product::findOrFail($id);       
        $cart = Cart::where('product_id', $product->id)
                    ->where('clubmember_id', $clubmemberId)
                    ->first();
        $varients=Varient::where('product_id', $product->id)->get();

        $quantity = $cart ? $cart->quantity : 1;

        $clubmember = ClubMember::findOrFail($clubmemberId); 

        $address = Address::where('id', $clubmember->address_id)->get();
            
            // dd($address);
        return view('clubmember.product.booking', [
            'product'     => $product,
            'quantity'    => $quantity,
            'clubmember'  => $clubmember,
            'address'     => $address,
            'varients'    => $varients,
            ]);
        }

   public function placeorder(Request $request)
        {
            $micrositeId = 1; // Assuming microsite_id is 1 for now, replace with actual value as needed
            $request->validate([
                'varient_id' => 'required|exists:varients,id',
                'quantity'   => 'required|integer|min:1',
                'email'      => 'required|email',
                'phone'      => 'required|digits:10',
                'product_id' => 'required|exists:products,id',
                'clubmember_id' => 'required|exists:club_members,id',
                'club_id' => 'required|exists:clubs,id',
            ]);

                $variant = Varient::findOrFail($request->varient_id);

                $order = Order::updateOrCreate([
                    'quantity'        => $request->quantity,
                    'product_id'      => $variant->product_id,
                    'club_member_id'  => $request->clubmember_id,
                    'club_id'         => $request->club_id,
                    'varient_id'      => $variant->id,
                    'order_status_id' => 1,
                    'microsite_id'    => $micrositeId,
                ]);

                $varient=Varient::where('id', $variant->id)->update([
                    'stock' => $variant->stock - $request->quantity,
                ]);

            OrderItem::updateOrCreate([             
                'quantity'     => $request->quantity,
                'order_id'     => $order->id,
                'microsite_id' => $order->microsite_id,
                'product_id'   => $request->product_id,
                'status'       => $order->order_status_id,
            ]);

            return redirect()
                ->route('clubmember.viewproduct')
                ->with('success', 'Order added successfully!');
        }
}
