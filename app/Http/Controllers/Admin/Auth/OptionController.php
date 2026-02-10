<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Psy\Util\Str;

class OptionController extends Controller
{
     public function form_option_index()
    {
        $option = new Option(); // empty model
       
        return view('admin.option_management.form_option_index', compact('option'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'color'      => 'required|string|max:255',
         'size'      => 'required|string|max:255',
        'status'    => 'nullable|boolean',
    ]);

    

    Option::create([
        'color'       => $request->color,
        'size'       => $request->size,
        'status'     => $request->has('status'),
    ]);

    return redirect()
        ->route('admin.option_management.form_option_index')
        ->with('success', 'Option created successfully!');
}







    public function show(Request $request)
    {
         if($request->ajax()){
            $option=Option::query();
            // return DataTables::eloquent($admin)
            return datatables()
    ->eloquent($option)
      

            
            
//toggle button

             ->addColumn('status', function (Option $option) {

                return '
                 <span
                         id="status-label-'.$option->id.'" 
                          class=" '.( $option->status ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ).' ">
                            '.($option->status ? 'Active' : 'Inactive' ).'
                 </span>
                       
                        <div class="form-check form-switch">
                                     <input 
                                          class="form-check-input toggle-status"
                                          type="checkbox"
                                          name="status"
                                          data-id="'.$option->id.'"  '.($option->status ? 'checked' : '').'>
                         </div>';
            })



//End - toggle button


            ->addColumn('action', function (Option $option) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';


                //view button
                $actions .= '<button 
                                     type="button"
                                     class="btn btn-sm view-option"
                                     data-id="'.$option->id.'"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productListModal">
                                                             <i class="bi bi-eye-fill btn btn-outline-warning btn-sm"></i>
                            </button>';


                //edit button
                $actions .= '<a
                                href="' . route('admin.option_management.edit_option_index', $option->id) . '"
                                class="btn btn-sm 
                                title="Edit">
                                                              <i class="bi bi-pencil-square btn btn-outline-success btn btn-sm"></i>
                            </a>';


                //delete button
                $actions .= '<button 
                                 type="button"
                                 class="btn btn-sm  delete-admin"
                                 onclick="deleteOption(' . $option->id . ')"
                                 title="Delete">
                                                              <i class="bi-trash-fill btn btn-outline-danger btn btn-sm "></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns([ 'status','action'])->make(true);
        }

        return view('admin.option_management.show_option');
    }


public function edit_option_index($id)
    {
        $option = Option::findOrFail($id);
       
        return view('admin.option_management.form_option_index', compact('option'));
    }



      public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
        ]);

        Option::where('id', $id)->update([
             'name' => $request->name,
        ]);
        return redirect()
            ->route('admin.option_management.show_option')
            ->with('success', 'Option updated successfully');
    }





    public function single_show($id)
{
    $option = Option::findOrFail($id);

    return response()->json([
        'id' => $option->id,
        'name' => $option->name,
    ]);
}


    


     public function changeStatus(Request $request)
    {
        $option = Option::find($request->id);
        if ($option) {
            $option->status = $request->status;
            $option->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }


    
    public function destroy($id)
{
    $option = Option::findOrFail($id);
    $option->delete();

    return response()->json([
        'message' => 'Option deleted successfully'
    ]);
}

}
