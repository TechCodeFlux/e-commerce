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
        
        return view('clubmember.dashboard',);
    }   



 public function viewproduct(Request $request)
    {
        $clubid=1;
         if($request->ajax()){
            $product=Product::where('status',1)//;
                            ->where('club_id',$clubid);
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($product)
    ->addColumn('image', function ($row) {
            if ($row->image) {
                return '<img src="'.asset('storage/'.$row->image).'" 
                        width="60" height="60" class="rounded">';
            }
            return '<span class="text-muted">No Image</span>';
        })
        ->addColumn('action', function (Product $product) use ($request) {
                $actions= '<div class="container-xxl d-flex gap-1 " ><div class="dropdown ms-md-5">';
                // Add to cart button
                $actions .= '<a href="'.route('clubmember.addcart',$product->id).'"class="btn btn-sm btn-clean btn-icon" title="Add to Cart">
                                <i class="fas fa-shopping-cart fa-lg text-center" style="color: #28a745;"></i>
                            </a>';

                // Buy now button 
                $actions .= '<a href="'.route('clubmember.booking',$product->id). '" class="btn btn-sm me-2" title="Buy Now">
                                <i class="fas fa-credit-card fa-l -center"></i>
                            </a>';

               
                
              

                $actions .= '</div><div>';
                return  $actions;
            })->rawColumns(['image','action'])->make(true);
            
        }

        return view('clubmember.product.viewproduct');
    }


   


// add to cart and process


    
    public function addcart($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('clubmember_id', 0)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // product already in cart → increment
            $cart->increment('quantity');

            return redirect()
                ->route('clubmember.viewproduct')
                ->with('success', 'Product quantity updated in cart!');
        }

        // product not in cart → create new
        Cart::create([
            'name' => $product->name,
            'stock' => $product->stock,
            'image' => $product->image,
            'description' => $product->description,
            'quantity' => 1,
            'clubmember_id' => 0,
            'microsite_id' => $product->microsite_id,
            'product_id' => $product->id,
            'club_id' => $product->club_id,
        ]);

        return redirect()
            ->route('clubmember.viewproduct')
            ->with('success', 'Product added to cart successfully!');
    }


    public function viewcart()
    {
         $cartItems = Cart::where('clubmember_id', 0)->get();
         return view('clubmember.layouts.topbar', compact('cartItems'));
    }

    public function delete($id){

        $cart = Cart::findOrFail($id);
        $cart->delete(); 
        return redirect()->back()->with('success', 'cart as deleted successfully');
    }




    //booking product

   public function booking($id)
   {
    $product = Product::findOrFail($id);

   $cart = Cart::where('product_id', $product->id)
            ->where('clubmember_id','1')
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
