<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\Varient;
use Illuminate\Http\Request;

class VarientController extends Controller
{
public function generate_varient($productId = null)
{
    $varient = new Varient();

    $optionColorId = Option::where('name', 'Color')->value('id');
    $optioncolorvalues = OptionValue::where('option_value_id', $optionColorId)->get();

    $optionSizeId = Option::where('name', 'Size')->value('id');
    $optionsizevalues = OptionValue::where('option_value_id', $optionSizeId)->get();

    $product = null;

    if ($productId) {
        $product = Product::with('varients')->findOrFail($productId);
    }

    return view(
        'admin.varient_management.generate_varient',
        compact(
            'varient',
            'optioncolorvalues',
            'optionsizevalues',
            'product'
        )
    );
}


public function store(Request $request)
{
    $request->validate([
        'variants' => 'required|array|min:1',

    'variants.*.color' => 'required|string',
    'variants.*.size'  => 'required|string',
    'variants.*.stock' => 'required|integer|min:0',
   'variants' => 'required|array|min:1',
    'variants.*.image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
], [
    'variants.*.image.required' => 'Variant image is required.',
    ]);

   $productData = session('product');

    $product = Product::create([
            'name'        => $productData['name'],
            'description' => $productData['description'],
            'image'       => $productData['image'],
            'status'      => $productData['status'],
            'category_id' => $productData['category_id'],
     ]);

    session()->forget('product');


   foreach ($request->variants as $index => $variant) {

    $imagePath = null;

    if ($request->hasFile("variants.$index.image")) {
        $imagePath = $request->file("variants.$index.image")
                             ->store('varients', 'public');
    }

    Varient::create([
        'color' => $variant['color'],
        'size'  => $variant['size'],
        'stock' => $variant['stock'],
        'image' => $imagePath,   // ← added
        'product_id' => $product->id,
    ]);
}

    return redirect()
        ->route('admin.product_management.show_products')
        ->with('success', 'Products saved successfully');
}



public function edit_varient_generator($productId = null)
{
     $varient = new Varient();

    $optionColorId = Option::where('name', 'Color')->value('id');
    $optioncolorvalues = OptionValue::where('option_value_id', $optionColorId)->get();

    $optionSizeId = Option::where('name', 'Size')->value('id');
    $optionsizevalues = OptionValue::where('option_value_id', $optionSizeId)->get();

    $product = null;

    if ($productId) {
        $product = Product::with('varients')->findOrFail($productId);
    }

    return view('admin.varient_management.edit_varient_generator', compact(
        'product',
        'optioncolorvalues',
        'optionsizevalues'
    ));
}

public function update(Request $request, $id)
{
    $request->validate([
        'variants' => 'required|array|min:1',
        'variants.*.color' => 'required',
        'variants.*.size'  => 'required',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Load product WITH variants
    $product = Product::with('varients')->findOrFail($id);

    $productData = session('product');

    if ($productData) {
        $product->update([
            'name'        => $productData['name'],
            'description' => $productData['description'],
            'image'       => $productData['image'],
            'status'      => $productData['status'],
            'category_id' => $productData['category_id'],
        ]);

        session()->forget('product');
    }

    // ✅ Store old variants before delete
    $oldVariants = $product->varients->keyBy(function ($item) {
        return $item->color . '-' . $item->size;
    });

    // ✅ Delete old variants
    Varient::where('product_id', $id)->delete();

    foreach ($request->variants as $index => $variant) {

        $key = $variant['color'] . '-' . $variant['size'];

        // 🔥 Get old image if exists
        $imagePath = $oldVariants[$key]->image ?? null;

        // 🔥 If new image uploaded → overwrite
        if ($request->hasFile("variants.$index.image")) {
            $image = $request->file("variants.$index.image");
            $imagePath = $image->store('variant_images', 'public');
        }

        Varient::create([
            'product_id' => $product->id,
            'color'      => $variant['color'],
            'size'       => $variant['size'],
            'stock'      => $variant['stock'],
            'image'      => $imagePath,
        ]);
    }

    return redirect()
        ->route('admin.product_management.show_products')
        ->with('success', 'Products updated successfully');
}


    public function show(Request $request)
    {
         if($request->ajax()){
            $varient=Varient::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($varient)
      

            ->addColumn('action', function (Varient $varient) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';


                //view button
                $actions .= '<button 
                                     type="button"
                                     class="btn btn-sm view-varient"
                                     data-id="'.$varient->id.'"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productListModal">
                                                             <i class="bi bi-eye-fill btn btn-outline-warning btn-sm"></i>
                            </button>';


         

                //delete button
                $actions .= '<button 
                                 type="button"
                                 class="btn btn-sm  delete-admin"
                                 onclick="deleteVarient(' . $varient->id . ')"
                                 title="Delete">
                                                               <i class="fas fa-trash-alt"></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns([ 'status','action'])->make(true);
        }

        return view('admin.varient_management.show_varient');
    }


    public function single_show($id)
{
    $varient = Varient::findOrFail($id);

    return response()->json([
        'id' => $varient->id,
        'size' => $varient->size,
        'color'=> $varient->color,
        'stock'=>$varient->stock,
    ]);
}



     public function changeStatus(Request $request)
    {
        $varient = Varient::find($request->id);
        if ($varient) {
            $varient->status = $request->status;
            $varient->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }


    
    public function destroy($id)
{
    $varient = Varient::findOrFail($id);
    $varient->delete();

    return response()->json([
        'message' => 'Varient deleted successfully'
    ]);
}

}
