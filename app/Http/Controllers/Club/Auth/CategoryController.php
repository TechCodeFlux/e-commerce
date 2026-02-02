<?php

namespace App\Http\Controllers\Club\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Container\Attributes\Storage;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class CategoryController extends Controller
{
    public function add_category_index(){
        $category = new Category();
       return  view('club.category_management.add_category_index', compact('category'));
    }

    public function store(Request $request){

          $validated = $request->validate([
        'name'    => 'required|string|max:255',
      //  'status'       => 'required',//'nullable',
    ]);

          Category::create([
             'name' => $request->name,
          ]);
        return redirect('club/category_management/show_category');
    }





    public function show(Request $request)
    {
         if($request->ajax()){
            $category=Category::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($category)
      

            
            
//toggle button
             ->addColumn('status', function (Category $category) {

                return '
                 <span
                         id="status-label-'.$category->id.'" 
                          class=" '.( $category->status ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ).' ">
                            '.($category->status ? 'Active' : 'Inactive' ).'
                 </span>
                       
                        <div class="form-check form-switch">
                                     <input 
                                          class="form-check-input toggle-status"
                                          type="checkbox"
                                          name="status"
                                          data-id="'.$category->id.'"  '.($category->status ? 'checked' : '').'>
                         </div>';
            })



//toggle button
            ->addColumn('action', function (Category $category) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';


                //view button
                $actions .= '<button 
                                     type="button"
                                     class="btn btn-sm view-category"
                                     data-id="'.$category->id.'"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productListModal">
                                                             <i class="bi bi-eye-fill btn btn-outline-warning btn-sm"></i>
                            </button>';


                //edit button
                $actions .= '<a
                                href="' . route('club.category_management.edit_category_index', $category->id) . '"
                                class="btn btn-sm 
                                title="Edit">
                                                              <i class="bi bi-pencil-square btn btn-outline-success btn btn-sm"></i>
                            </a>';


                //delete button
                $actions .= '<button 
                                 type="button"
                                 class="btn btn-sm  delete-club"
                                 onclick="deleteCategory(' . $category->id . ')"
                                 title="Delete">
                                                              <i class="bi-trash-fill btn btn-outline-danger btn btn-sm "></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns([ 'status','action'])->make(true);
        }

        return view('club.category_management.show_category');
    }




    public function single_show($id)
{
    $category = Category::findOrFail($id);

    return response()->json([
        'id' => $category->id,
        'name' => $category->name,
    ]);
}


    



     public function changeStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }



    public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return response()->json([
        'message' => 'Category deleted successfully'
    ]);
}


     public function edit_category_index($id){
        

        $club = Auth::guard('club')->user();

         $category = Category::where('id', $id)
        ->firstOrFail();
          return view('club.category_management.add_category_index',compact('category'));
    }



     public function update(Request $request, $id){ 

          $request->validate([
            'name'    => 'required|string|max:255',
            
        ]);

        Category::where('id', $id)->update([
             'name' => $request->name,
]);
          return redirect('club/category_management/show_category'); 


    }

    
    
}
