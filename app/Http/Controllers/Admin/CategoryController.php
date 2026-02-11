<?php

namespace App\Http\Controllers\Admin;
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
        $category_list = Category::orderBy('name')->get(); 
       return  view('admin.category_management.add_category_index', compact('category','category_list'));
    }

    public function store(Request $request){

          $validated = $request->validate([
        'name'    => 'required|string|max:255',
      //  'status'       => 'required',//'nullable',
    ]);

          Category::create([
             'name' => $request->name,
             'parent_id' => $request->category ? $request->category : 0 ,
            'status'=> $request->status ? 1 : 0,    
          ]);
        return redirect('admin/category_management/show_category');
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
               


                //edit button
                $actions .= '<a
                                href="' . route('admin.category_management.edit_category_index', $category->id) . '"
                                 class="btn btn-sm btn-outline-secondary me-2"
                                title="Edit">
                                    <i class="fas fa-pencil-alt"></i> 
                            </a>';


                //delete button
                $actions .= '<button 
                                 type="button"
                                 class="btn btn-sm btn-outline-danger delete-club-member"
                                 onclick="deleteCategory(' . $category->id . ')"
                                 title="Delete">
                                                              <i class="fas fa-trash-alt"></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns([ 'status','action'])->make(true);
        }

        return view('admin.category_management.show_category');
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
         $category_list = Category::orderBy('name')->get(); 
          return view('admin.category_management.add_category_index',compact('category','category_list'));
    }



     public function update(Request $request, $id){ 

          $request->validate([
            'name'    => 'required|string|max:255',
            
        ]);

        Category::where('id', $id)->update([
             'name' => $request->name,
             'parent_id' => $request->category ? $request->category : 0 ,
]);
          return redirect('admin/category_management/show_category'); 


    }

    
    
}