<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
        public function add(Request $request)
        {
            $variantId = $request->variant_id;

            // 1. Get variant
            $variant = DB::table('varients')->where('id', $variantId)->first();

            if (!$variant) {
                return response()->json(['error' => 'Variant not found'], 404);
            }

            // 2. Get product
            $product = DB::table('products')->where('id', $variant->product_id)->first();

            // 3. Identify user (adjust if no auth)
            $clubmemberId = auth()->id() ?? 1;

            // 4. Check existing cart item
            $existing = DB::table('carts')
                ->where('varient_id', $variant->id)
                ->where('clubmember_id', $clubmemberId)
                ->first();

            if ($existing) {

                // ✅ Increase quantity
                DB::table('carts')
                    ->where('id', $existing->id)
                    ->increment('quantity', 1);

            } else {

                // ✅ Insert new item
                DB::table('carts')->insert([
                    'name' => $product->name ?? 'Product',
                    'varient_id' => $variant->id,
                    'quantity' => 1,
                    'price' => $variant->price ?? 0,
                    'clubmember_id' => $clubmemberId,
                    'microsite_id' => $product->microsite_id ?? 1,
                    'product_id' => $variant->product_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json(['success' => true]);
        }

        public function index()
        {
            $clubmemberId = auth()->id() ?? 1;

            $cartItems = DB::table('carts')
                ->join('varients', 'carts.varient_id', '=', 'varients.id')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->select(
                    'carts.*',
                    'products.name as product_name',
                    'varients.size',
                    'varients.color',
                    'varients.image'
                )
                ->where('carts.clubmember_id', $clubmemberId)
                ->get();

            return view('clubmember.microsite.carts', compact('cartItems'));
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
}
