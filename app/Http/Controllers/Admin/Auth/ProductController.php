<?php

namespace App\Http\Controllers\Admin\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Storage;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Varient;

class ProductController extends Controller
{
    public function form_products_index(){
       $product = new Product();
        $categories = Category::orderBy('name')->get(); 
        
       return  view('admin.product_management.form_products_index', compact('product','categories'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category'    => 'required|integer|exists:categories,id',
    ]);

    // store image temporarily
$imagePath = $request->file('image')->store('products', 'public');
    // ✅ write to session
    session()->put('product', [
        'name'        => $request->name,
        'description' => $request->description,
        'image'       => $imagePath,
        'status'      => $request->status ? 1 : 0,
        'category_id' => $request->category,
    ]);

    return response()->json([
        'success' => true
    ]);
}



    



     public function edit_product_index($id){
        

        $admin = Auth::guard('admin')->user();

         $product = Product::where('id', $id)->firstOrFail();

         $categories = Category::orderBy('name')->get();
         
         $options = Option::orderBy('name')->get();
          return view('admin.product_management.form_products_index',compact('product','categories','options'));
    }


     public function update(Request $request, $id){ 

          $request->validate([
            'name'    => 'required|string|max:255',
            'stock' => 'required|string',
            'description' => 'required|string|max:20',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
             'category'   => 'required|integer|exists:categories,id',
            
        ]);


         $imagePath = $request->file('image')->store('products', 'public');

        Product::where('id', $id)->update([
               'name' => $request->name,
        'stock' => $request->stock,
        'description' => $request->description,
         'image'       => $imagePath,
         'category_id' => $request->category,
]);
          return redirect('admin/product_management/show_products'); 


    }





    public function show(Request $request)
    {
         if($request->ajax()){
            $product = Product::with('varients')->latest();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($product)


//varient connection

//     ->addColumn('varients', function (Product $product) {

//     if ($product->varients->count() > 0) {
//         $output = '';

//         foreach ($product->varients as $varient) {
//             $output .= '<span class="badge bg-info me-1 bg-purple">'
//             . $varient->color . ' - ' . $varient->size .
//            '</span><br>';
//         }

//         return $output;
//     }

//     return '--';
// })
      
//add product-image for image scale
              ->addColumn('image', function (Product $product) {
                if ($product->image) {
                    return '<img src="'.asset('storage/'.$product->image).'"
                                width="100" class="mx-md-5 product-image"
                                
                                style="object-fit:cover;border-radius:6px;">';
                }
                return '--';
            })

            
//toggle button
             ->addColumn('status', function (Product $product) {

                return '
                 
                       
                        <div class="form-check form-switch">
                                     <input 
                                          class="form-check-input toggle-status"
                                          type="checkbox"
                                          name="status"
                                          data-id="'.$product->id.'"  '.($product->status ? 'checked' : '').'>
                         </div>';
            })



//toggle button
            ->addColumn('action', function (Product $product) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';


                //view button
                $actions .= '<button 
                                     type="button"
                                     class="btn btn-sm view-product btn-outline-warning me-2 "
                                     data-id="'.$product->id.'"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productListModal">
                                                              <i class="fas fa-eye"></i> 
                            </button>';


                //edit button
                $actions .= '<a
                                href="' . route('admin.product_management.edit_products_index', $product->id) . '"
                                class="btn btn-sm btn-outline-secondary me-2 
                                title="Edit">
                                                             <i class="fas fa-pencil-alt"></i> 
                            </a>';


                //delete button
                $actions .= '<button 
                                 type="button"
                                 class=" btn btn-sm btn-outline-danger delete-club-member"
                                 onclick="deleteProduct(' . $product->id . ')"
                                 title="Delete">
                                                               <i class="fas fa-trash-alt"></i> 
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns(['image', 'status','action','varients'])->make(true);
        }

        return view('admin.product_management.show_products');
    }


    public function single_show($id)
{
   $product = Product::with('varients','categories')->findOrFail($id);

    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'image' => asset('storage/' . $product->image),
        'description' => $product->description,
        'status' => $product->status,
        'varients' => $product->varients,
        'categories' => $product->categories
    ]);
}


    



     public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->status = $request->status;
            $product->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Product not found.'], 404);
    }



    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ]);
}


    
    
}
