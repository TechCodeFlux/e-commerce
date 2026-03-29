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
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 




class ClubmemberOrderControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $clubid = 1;
    $clubmemberId = 1; // club_member_id is hardcoded for now, replace with auth()->id() when authentication is implemented

    if ($request->ajax()) {
        
        $orders = Order::with('product', 'varient', 'clubmember', 'order_status','address')
            // ->where('order_status_id', 1)
            ->where('club_id', $clubid)
            ->where('club_member_id', $clubmemberId)
            ->orderBy('order_status_id', 'desc'); 

        return datatables()
            ->eloquent($orders)

            ->addColumn('name', fn ($row) => $row->product->name ?? '--')

            ->addColumn('description', fn ($row) => $row->product->description ?? '--')

            ->addColumn('stock', fn ($row) => $row->varient->stock ?? 0)
            ->editColumn('created_at', fn($m) => $m->created_at->format('d M Y'))

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
             ->addColumn('image', function ($row) {
                if ($row->varient && $row->varient->image) {
                    return asset('storage/' . $row->varient->image);
                }
                return '<span class="text-muted">No Image</span>';
                })

            ->addColumn('order_status', fn ($row) => optional($row->order_status)->status ?? '--')
            ->addColumn('action', function ($row) {

                    return optional($row->order_status)->status == "Out for delivery"
                        ? '<div>
                                <a href="'. route('admin.clubmember.orderstatus', $row->id) .'" 
                                class="btn btn-sm btn-clean btn-icon" 
                                title="delivered">
                                
                                <i class="btn btn-sm btn-danger">Confirm delivery</i>
                                </a>
                        </div>'
                        : '';

                })       
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
    public function store(Request $request)   //add to cart
    {        
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

    public function cartorder($ids)
    {
        $clubmemberId = 1; // Replace with auth()->id() in production
        $idsArray = explode(',', $ids);

        // Load countries
        $countries = Country::orderBy('name')->get();

        // Eager load varients to prevent null property errors
        $cart = Cart::with('varient')
            ->whereIn('id', $idsArray)
            ->where('clubmember_id', $clubmemberId)
            ->get();

        $varientIds = $cart->pluck('varient_id')->filter(); // filter removes nulls

        // Get the varients from DB
        $varients = Varient::whereIn('id', $varientIds)
                        ->where('stock', '>', 0)
                        ->get()
                        ->keyBy('id');

        $clubmember = ClubMember::findOrFail($clubmemberId);

        $address = Address::with(['country', 'state'])
            ->where('clubmember_id', $clubmemberId)
            ->get();

        return view('clubmember.product.booking', compact('cart','countries','clubmember','address','varients'));
    }


        public function addaddress(Request $request)
        {
            $request->validate([
                'new_address'    => 'required_without:address|nullable|string|max:255',
                'country'        => 'required_without:address|nullable|string|max:100',
                'state'          => 'required_without:address|nullable|string|max:100',
                'city'           => 'required_without:address|nullable|string|max:80',
                'zip_code'       => 'required_without:address|nullable|digits:6',
                'clubmember_id'  => 'required|exists:club_members,id',
            ]);
             $address = Address::create([
                                        'address1'  => $request->new_address,
                                        'country_id'=> $request->country,
                                        'state_id'  => $request->state,
                                        'clubmember_id'=>$request->clubmember_id,
                                        'city'      => $request->city,
                                        'zip_code'  => $request->zip_code,
                                        'status'    => 1,
                                    ]);

            return redirect()
                ->back()
                ->with('success', 'address added successfully!');                      
        }


      

public function placeorder(Request $request)
{
    $micrositeId = 1;

    $request->validate([
        'product_id'     => 'required|array',
        'quantity'       => 'required|array',
        'price'          => 'required|array',
        'varient_id'     => 'required|array',
        'clubmember_id'  => 'required|exists:club_members,id',
        'address_id'     => 'required|exists:addresses,id',
        'club_id'        => 'required',
    ]);

    DB::beginTransaction();

    try {

        foreach ($request->product_id as $index => $productId) {

            $variantId = $request->varient_id[$index] ?? null;
            $qty       = $request->quantity[$index] ?? 1;
            $price     = $request->price[$index] ?? 0;

            if (!$variantId) continue;

            $variant = Varient::lockForUpdate()
                        ->where('id', $variantId)
                        ->where('product_id', $productId)
                        ->first();

            // ✅ Stock check
            if (!$variant) {
                    throw new \Exception("Invalid variant ($variantId) for product ($productId)");
                }

            // ✅ Create Order
           $order = Order::create([
                    'quantity'        => $qty,
                    'product_id'      => $productId,
                    'price'           => (int) $price, // ✅ FIX
                    'club_member_id'  => $request->clubmember_id,
                    'club_id'         => $request->club_id,
                    'varient_id'      => $variantId,
                    'order_status_id' => 1,
                    'microsite_id'    => 1,
                    'address_id'      => $request->address_id,
                ]);

            // ✅ Reduce stock
            $variant->decrement('stock', $qty);

            // ✅ Create Order Item
            OrderItem::create([
                'quantity'     => $qty,
                'order_id'     => $order->id,
                'microsite_id' => $micrositeId,
                'product_id'   => $productId,
                'status'       => 1,
                'address_id'   => $request->address_id,
            ]);

            // ✅ Delete ONLY that cart item (IMPORTANT FIX)
            $cartId = $request->cart_id[$index] ?? null;
            if ($cartId) {
                Cart::where('id', $cartId)->delete();
            }
        }

        DB::commit();

        return redirect()
            ->route('clubmember.viewproduct')
            ->with('success', 'Order placed successfully!');
    }

        catch (\Exception $e) {

            DB::rollback();

            dd($e->getMessage(), $e->getLine());
        }
}
}
