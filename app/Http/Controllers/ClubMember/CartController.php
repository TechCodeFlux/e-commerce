<?php

namespace App\Http\Controllers\ClubMember;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         
         $cartItems = Cart::where('clubmember_id', 1)->get();        // clubmember_id is hardcoded for now, replace with auth()->id() when authentication is implemented
        
         return view('clubmember.layouts.topbar', compact('cartItems'));
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
    public function store(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('clubmember_id', 1)  // clubmember_id is hardcoded for now, replace with auth()->id() when authentication is implemented
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
            'clubmember_id' => 1,
            'microsite_id' => $product->microsite_id,
            'product_id' => $product->id,
            'club_id' => $product->club_id,
        ]);

        return redirect()
            ->route('clubmember.viewproduct')
            ->with('success', 'Product added to cart successfully!');
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
