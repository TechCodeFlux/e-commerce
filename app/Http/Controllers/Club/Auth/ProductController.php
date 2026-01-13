<?php

namespace App\Http\Controllers\Club\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add_products_index(){
       return  view('club.add_products_index');
    }

    public function store(Request $request){

    $valid=$request->validate(
        [
            'name'=>'required',
            'stock'=>'required|integer',
            'description'=>'required|string',
            //'imagepath'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]
    );

        $product = new Product();
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
        $product->save();
        return redirect('club/add_products_index');
    }

    public function show(){
        $products = Product::all();
        return view('club.show_products',compact('products'));


    }

     public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete(); 
         return redirect('club/show_products');


    }

    
    
}
