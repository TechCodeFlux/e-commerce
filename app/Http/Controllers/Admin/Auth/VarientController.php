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
//     public function form_varient_index()
// {
//     $varient = new Varient();
//     $optionColorId  =  Option::where('name', 'Color')->value('id');
//     $optioncolorvalues  = OptionValue::where('option_value_id', $optionColorId)->get();

//     $optionSizeId  =  Option::where('name', 'Size')->value('id');
//     $optionsizevalues  = OptionValue::where('option_value_id', $optionSizeId)->get();
   


//     return view(
//         'admin.varient_management.form_varient_index',
//         compact('varient','optioncolorvalues','optionsizevalues')
//     );
// }


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
        'variants.*.color' => 'required',
        'variants.*.size'  => 'required',
        'variants.*.stock'    => 'required|integer|min:0',
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


    foreach ($request->variants as $variant) {

        Varient::create([
            'color' => $variant['color'],   // store ID
            'size'  => $variant['size'],    // store ID
            'stock' => $variant['stock'],   
            'product_id' => $product->id,
        ]);
    }

    return redirect()
        ->route('admin.product_management.form_products_index')
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
    ]);

    // ✅ Get existing product directly from DB
    $product = Product::findOrFail($id);

    // ✅ If session exists (coming from step 1), update product
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

    // ✅ Delete old variants of this product
    Varient::where('product_id', $id)->delete();

    // ✅ Insert new variants
    foreach ($request->variants as $variant) {

        Varient::create([
            'color'      => $variant['color'],
            'size'       => $variant['size'],
            'stock'      => $variant['stock'],
            'product_id' => $id,
        ]);
    }

    return redirect()
        ->route('admin.product_management.form_products_index')
        ->with('success', 'Products updated successfully');
}



    public function show(Request $request)
    {
         if($request->ajax()){
            $varient=Varient::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($varient)
      

            
            
//toggle button
            //  ->addColumn('status', function (Varient $varient) {

            //     return '
                
                       
            //             <div class="form-check form-switch">
            //                          <input 
            //                               class="form-check-input toggle-status"
            //                               type="checkbox"
            //                               name="status"
            //                               data-id="'.$varient->id.'"  '.($varient->status ? 'checked' : '').'>
            //              </div>';
            // })



//toggle button
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


                //edit button
                $actions .= '<a
                                href="' . route('admin.varient_management.edit_varient_index', $varient->id) . '"
                                class="btn btn-sm 
                                title="Edit">
                                                              <i class="bi bi-pencil-square btn btn-outline-success btn btn-sm"></i>
                            </a>';


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


public function edit_varient_index($id)
    {
        $varient = Varient::findOrFail($id);
       
        return view('admin.varient_management.form_varient_index', compact('varient'));
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
