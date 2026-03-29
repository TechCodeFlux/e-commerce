<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
use App\Models\Microsite;
use App\Models\Club;

class CartController extends Controller
{
            public function add(Request $request, $slug)
            {
                $request->validate([
                    'variant_id' => 'required|integer',
                    'quantity' => 'nullable|integer|min:1'
                ]);
                $variantId = $request->variant_id;
                $quantity = $request->quantity ?? 1;
                $microsite = DB::table('microsite')->where('slug', $slug)->first();
                if (!$microsite) {return response()->json(['error' => 'Microsite not found'], 404);}
                $variant = DB::table('varients')->where('id', $variantId)->first();
                if (!$variant) {return response()->json(['error' => 'Variant not found'], 404);}
                $product = DB::table('products')->where('id', $variant->product_id)->first();
                if (!$product) {return response()->json(['error' => 'Product not found'], 404);}
                $clubmemberId = session('clubmember_id'); 
                if (!$clubmemberId) {return response()->json(['error' => 'User not logged in'], 403);}
                $existing = DB::table('carts')
                    ->where('clubmember_id', $clubmemberId)
                    ->where('product_id', $product->id)
                    ->where('varient_id', $variant->id)
                    ->where('microsite_id', $microsite->id)
                    ->first();
                if ($existing) 
                {
                    DB::table('carts')
                        ->where('id', $existing->id)
                        ->update([
                            'quantity' => $existing->quantity + $quantity,
                            'updated_at' => now()]);
                    return response()->json(['success' => true, 'message' => 'Cart updated']);
                }
                $cartId = DB::table('carts')->insertGetId([
                    'name' => $product->name,
                    'product_id' => $product->id,
                    'varient_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $variant->price,
                    'clubmember_id' => $clubmemberId,
                    'microsite_id' => $microsite->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return response()->json(['success' => true, 'cart_id' => $cartId]);
            }
            public function index($slug)
            {
                $microsite = Microsite::where('slug', $slug)->firstOrFail();
                $club = Club::findOrFail($microsite->club_id);
                $clubmemberId = auth()->id() ?? session('clubmember_id'); // fallback to session if not auth
                $cartItems = DB::table('carts')
                    ->join('varients', 'carts.varient_id', '=', 'varients.id')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.clubmember_id', $clubmemberId)
                    ->where('carts.microsite_id', $microsite->id) // ✅ Filter by microsite
                    ->select(
                        'carts.*',
                        'products.name as product_name',
                        'varients.size',
                        'varients.color',
                        'varients.image'
                    )
                    ->get();
                return view('clubmember.microsite.carts', compact('cartItems', 'microsite', 'club'));
            }
            public function update(Request $request)
            {
                DB::table('carts')
                    ->where('id', $request->id)
                    ->update(['quantity' => $request->quantity]);
                return response()->json(['success' => true]);
            }
            public function remove(Request $request)
            {
                DB::table('carts')
                    ->where('id', $request->id)
                    ->delete();
                return response()->json(['success' => true]);
            }
            public function preview($slug)
            {
                $microsite = Microsite::where('slug', $slug)->firstOrFail();
                $club = Club::findOrFail($microsite->club_id);
                $clubmemberId = session('clubmember_id');
                if (!$clubmemberId) {
                    return redirect()->route('microsite.login', $microsite->slug);
                }
                $user = DB::table('club_members')->where('id', $clubmemberId)->first();
                $cartItems = DB::table('carts')
                    ->join('varients', 'carts.varient_id', '=', 'varients.id')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.clubmember_id', $clubmemberId)
                    ->where('carts.microsite_id', $microsite->id)
                    ->select(
                        'carts.*',
                        'products.name as product_name',
                        'varients.size',
                        'varients.color',
                        'varients.image'
                    )
                    ->get();
                $addresses = DB::table('addresses')
                    ->where('club_member_id', $clubmemberId)
                    ->get();
                $country = DB::table('countries')->get();
                $state = DB::table('states')->get();
                return view('clubmember.microsite.preview', compact('cartItems', 'microsite', 'club', 'user','addresses', 'country', 'state'));
            }
            public function addAddress(Request $request, $slug)
            {
                $request->validate([
                    'address_line1' => 'required|string|max:255',
                    'address_line2' => 'nullable|string|max:255',
                    'country_id'    => 'required|integer',
                    'state_id'      => 'required|integer',
                    'city'          => 'required|string|max:255',
                    'zip_code'      => 'required|string|max:20',
                ]);
                $clubmemberId = session('clubmember_id');
                if (!$clubmemberId) {
                    return back()->with('error', 'User not logged in');
                }
                $addressId = DB::table('addresses')->insertGetId([
                    'address1'   => $request->address_line1,
                    'address2'   => $request->address_line2,
                    'country_id' => $request->country_id,
                    'state_id'   => $request->state_id,
                    'city'       => $request->city,
                    'zip_code'   => $request->zip_code,
                    'club_member_id'  => $clubmemberId,
                    'club_id'    => DB::table('club_members')->where('id', $clubmemberId)->value('club_id'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            return redirect()
                ->route('clubmember.microsite.preview', $slug)
                ->with('success', 'Address added successfully');
            }       
            public function checkout(Request $request, $slug)
            {
                $clubmemberId = session('clubmember_id');
                $micrositeId  = session('microsite_id');
                $clubId       = session('club_id');
                $request->validate([
                    'address_id' => 'required'
                ]);
                DB::beginTransaction();
                try {
                    $cartItems = DB::table('carts')
                        ->where('clubmember_id', $clubmemberId)
                        ->where('microsite_id', $micrositeId)
                        ->get();

                    if ($cartItems->isEmpty()) {
                        return back()->with('error', 'Cart is empty');
                    }
                    $grandTotal = 0;
                    foreach ($cartItems as $item) {
                        $grandTotal += ($item->price * $item->quantity);
                    }
                    $orderId = DB::table('orders')->insertGetId([
                        'club_member_id' => $clubmemberId,
                        'club_id'        => $clubId,
                        'microsite_id'   => $micrositeId,
                        'address_id'     => $request->address_id,
                        'total_amount'   => $grandTotal,
                        'order_status_id'=> 1,
                        'created_at'     => now(),
                        'updated_at'     => now()
                    ]);
                    foreach ($cartItems as $item) {

                        DB::table('order_items')->insert([
                            'order_id'   => $orderId,
                            'product_id' => $item->product_id,
                            'variant_id' => $item->varient_id, 
                            'quantity'   => $item->quantity,
                            'price'      => $item->price,
                            'total'      => $item->price * $item->quantity,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        DB::table('varients')
                            ->where('id', $item->varient_id)
                            ->decrement('stock', $item->quantity);
                    }
                    DB::table('carts')
                        ->where('clubmember_id', $clubmemberId)
                        ->where('microsite_id', $micrositeId)
                        ->delete();

                    DB::commit();
                    return redirect()
                        ->route('microsite.home', $slug)
                        ->with('success', 'Order placed successfully');
                } catch (\Exception $e) {

                    DB::rollback();
                    // return back()->with('error', 'Checkout failed');
                    dd($e->getMessage());
                }
            }
}
        
