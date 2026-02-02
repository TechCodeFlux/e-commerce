<?php

namespace App\Http\Controllers\Club\Auth;
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
class ProductController extends Controller
{
    public function form_products_index(){
        $product = new Product();
        $categories = Category::orderBy('name')->get();
        $options = Option::orderBy('name')->get();
       return  view('club.form_products_index', compact('product','categories','options'));
    }

    public function store(Request $request){
          $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'stock' => 'required|string',   
        'description' => 'required|string|max:20',
         'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category'   => 'required|integer|exists:categories,id',
        'option'   => 'required|integer|exists:options,id',
        'status'    => 'nullable|boolean',
    ]);

    $imagePath = $request->file('image')->store('products', 'public');
        


          Product::create([
             'name' => $request->name,
        'stock' => $request->stock,
        'description' => $request->description,
         'image'       => $imagePath,
        'status'     => $request->status,
        
        'category_id' => $request->category,
        'option_id' =>$request->option,

          ]);
        return redirect('club/show_products');
    }




     public function edit_product_index($id){
        

        $club = Auth::guard('club')->user();

         $product = Product::where('id', $id)->firstOrFail();

         $categories = Category::orderBy('name')->get();
         
         $options = Option::orderBy('name')->get();
          return view('club.form_products_index',compact('product','categories','options'));
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
          return redirect('club/show_products'); 


    }





    public function show(Request $request)
    {
         if($request->ajax()){
            $product=Product::latest();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($product)
      
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
                 <span
                         id="status-label-'.$product->id.'" 
                          class=" '.( $product->status ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ).' ">
                            '.($product->status ? 'Active' : 'Inactive' ).'
                 </span>
                       
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
                                     class="btn btn-sm view-product"
                                     data-id="'.$product->id.'"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productListModal">
                                                             <i class="bi bi-eye-fill btn btn-outline-warning btn-sm"></i>
                            </button>';


                //edit button
                $actions .= '<a
                                href="' . route('club.edit_products_index', $product->id) . '"
                                class="btn btn-sm 
                                title="Edit">
                                                              <i class="bi bi-pencil-square btn btn-outline-success btn btn-sm"></i>
                            </a>';


                //delete button
                $actions .= '<button 
                                 type="button"
                                 class="btn btn-sm  delete-club"
                                 onclick="deleteProduct(' . $product->id . ')"
                                 title="Delete">
                                                              <i class="bi-trash-fill btn btn-outline-danger btn btn-sm "></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns(['image', 'status','action'])->make(true);
        }

        return view('club.show_products');
    }


    public function single_show($id)
{
    $product = Product::findOrFail($id);

    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'stock' => $product->stock,
        'image' => asset('storage/' . $product->image),
        'description' => $product->description,
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
