<?php

namespace App\Http\Controllers\ClubMember;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;


class ClubmemberDashboardController extends Controller
{
    public function index()
    {
        $clubmemberId = 1; // clubmember_id is hardcoded for now, replace with auth()->id() when authentication is implemented 
         $clubmember = ClubMember::where('id', $clubmemberId)->first();
        return view('clubmember.dashboard', compact('clubmember'));
    }   



 public function viewproduct(Request $request)
    {
    //        
    }


   


// add to cart and process


    
    public function addcart($id)
    {
    //    
    }


    public function viewcart()
    {
    // 
    }

    public function delete($id)
    {
    // 
    }




    //booking product

   public function booking($id)
   {
    $product = Product::findOrFail($id);
    $clubmemberId = 1; // clubmember_id is hardcoded for now, replace with auth()->id() when authentication is implemented
   $cart = Cart::where('product_id', $product->id)
            ->where('clubmember_id',$clubmemberId)
            ->first();

    if ($cart === null) {
        $quantity = 1;
    } else {
        $quantity = $cart->quantity;
    }

    $clubmember = ClubMember::findOrFail(1);

   $address = Address::where('club_member_id', $clubmember->id)->get();
   
   

    
    // dd($address);
   return view('clubmember.product.booking', [
    'product'     => $product,
    'quantity'    => $quantity,
    'clubmember'  => $clubmember,
    'address'   => $address,
    ]);
   }


   public function placeorder(Request $request)
    {
    $request->validate([
        'quantity' => 'required',
        'email'    => 'required|email',
        'phone'    => 'required|digits:10',
    ]);

    // Insert into orders table
    $order = new Order();
    $order->quantity        = $request->quantity;
    $order->product_id      = $request->product_id;
    $order->club_member_id  = $request->clubmember_id;
    $order->club_id         = $request->club_id;
    $order->order_status_id = 1;
    $order->microsite_id    = 1;
    $order->save();

    // Insert into order_items table
    $order_item = new OrderItem();
    $order_item->quantity      = $request->quantity;
    $order_item->order_id      = $order->id;   // ✅ THIS IS THE FIX
    $order_item->microsite_id  = $order->microsite_id;
    $order_item->product_id    = $request->product_id;
    $order_item->status        = $order->order_status_id;
    $order_item->save();

    return redirect()
        ->route('clubmember.viewproduct')
        ->with('success', 'Order added to cart successfully!');
    }

    public function vieworder(Request $request)
    {
    $clubid = 1;
    $memberId = 1;

    if ($request->ajax()) {

        $orders = Order::with('product')
            // ->where('order_status_id', 1)
            ->where('club_id', $clubid)
            ->where('club_member_id', $memberId);

        return datatables()
            ->eloquent($orders)

            ->addColumn('name', fn ($row) => $row->product->name ?? '--')

            ->addColumn('description', fn ($row) => $row->product->description ?? '--')

            ->addColumn('stock', fn ($row) => $row->product->stock ?? 0)

            //->addColumn('quantity', fn ($row) => $row->order->quantity )

            ->addColumn('image', function ($row) {
                if ($row->product && $row->product->image) {
                    return '<img src="'.asset('storage/'.$row->product->image).'"
                             width="60" height="60" class="rounded">';
                }
                return '<span class="text-muted">No Image</span>';
                })

            ->addColumn('username', fn ($row) => $row->clubmember->name ?? '--')
            ->addColumn('email', fn ($row) => $row->clubmember->email ?? '--')
            ->addColumn('phone', fn ($row) => $row->clubmember->contact ?? '--')

            ->addColumn('address', fn ($row) => $row->address->address1 ?? '--')

            //->addColumn('username', fn ($row) => $row->clubmember->name ?? '--')

            // ->addColumn('action', function ($row) {
            //     return '
            //     <a href="'.route('clubmember.addcart', $row->product_id).'" class="btn btn-sm">
            //         <i class="fas fa-shopping-cart text-success"></i>
            //     </a>

            //     <a href="'.route('clubmember.booking', $row->product_id).'" class="btn btn-sm">
            //         <i class="fas fa-credit-card"></i>
            //     </a>';
            // })

            ->rawColumns(['image','action'])
            ->make(true);
    }

    return view('clubmember.product.vieworder');
    }



    


}
