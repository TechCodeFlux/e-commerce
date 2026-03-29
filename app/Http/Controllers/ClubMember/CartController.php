<?php

namespace App\Http\Controllers\ClubMember;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Varient;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $clubmemberId = 1;
        $micrositeid = 1;

        $cartItems = Cart::where('clubmember_id', $clubmemberId)
            ->where('microsite_id', $micrositeid)
            ->get();
                        
            $total_price = 0;
          $multipleproductids=[];
            foreach ($cartItems as $item) {
                $multipleproductids[]=$item;
                if ($item->price) {
                    $total_price += $item->price; // ✅ correct addition
                }
            }

        $cartItemCount = $cartItems->count();

        return view('clubmember.layouts.topbar', compact('cartItems','cartItemCount','total_price','multipleproductids'));
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
    public function store(Request $request, $id)
        {
            $varient = Varient::findOrFail($id);
            $clubmemberId = 1;
            // $varient_id=$request->varient_id;
            // dd($varient_id);
            $product = Product::where('id', $varient->product_id)->first();  // not working 

            if (!$varient) {
                return back()->with('error', 'Variant not found');
            }

            $cart = Cart::where('clubmember_id', $clubmemberId)
                ->where('varient_id', $varient->id)
                ->first();

            // ✅ If already in cart
            if ($cart) {
                if($cart->quanitity > $varient->stock)
                    {
                       return redirect()
                        ->route('clubmember.viewproduct')
                        ->with('success', ' that must quanitity is not avaliable!'); 
                    }
                    else{

                    
            // product already in cart → increment
             $cart->increment('quantity');

            // reload updated value from DB
            $cart->refresh();

            $cart->price = $cart->quantity * $varient->price;
            $cart->save(); //not working based on quantity increses

            return redirect()
                ->route('clubmember.viewproduct')
                ->with('success', 'Product quantity updated in cart!');
                }
             }

            // ✅ New item
            Cart::create([
                'name' => $product->name,
                'quantity' => 1,
                'price' => $varient->price, // ✅ store price
                'clubmember_id' => $clubmemberId,
                'microsite_id' => $product->microsite_id,
                'product_id' => $product->id,
                'varient_id' => $id,
                
            ]);

            return back()->with('success', 'Added to cart!');
        }
    

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {        
        $cart = Cart::findOrFail($id);
        $cart->delete(); 
        return redirect()->back()->with('success', 'cart item deleted successfully');
    }
    
}
