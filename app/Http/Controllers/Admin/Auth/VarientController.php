<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Models\Varient;
use Illuminate\Http\Request;

class VarientController extends Controller
{
    public function form_varient_index()
{
    $varient = new Varient();
   


    return view(
        'admin.varient_management.form_varient_index',
        compact('varient')
    );
}


    public function generate_varient()
{
    $varient = new Varient();
     $options = Option::orderBy('color')->get(); 

    return view(
        'admin.varient_management.generate_varient',
        compact('varient','options')
    );
}


public function add_varient(Request $request)
{
    // Validate that the variants array exists
    $request->validate([
        'variants' => 'required|array',
        'variants.*.stock' => 'required|numeric|min:0'
    ]);

    foreach ($request->variants as $item) {
        Varient::updateOrCreate(
            [
                'color' => $item['color'],
                'size'  => $item['size'],
                // Add product_id here if applicable
            ],
            [
                'stock' => $item['stock']
            ]
        );
    }

    return response()->json(['message' => 'Variants generated and saved successfully!']);
}

    



    
    public function store(Request $request)
{
    $validated = $request->validate([
        'size'      => 'required|string|max:25',
        'color'      => 'required|string|max:25',
        'stock'      => 'required|integer|min:0|max:50',
        'status'    => 'nullable|boolean',
    ]);

   

    Varient::create([
        'size'       => $request->size,
        'color'       => $request->color,
        'stock'       => $request->stock,
        'status'     => $request->status,
    ]);

    return redirect()
            ->route('admin.varient_management.form_varient_index')
            ->with('success', 'Varient updated successfully');
}







    public function show(Request $request)
    {
         if($request->ajax()){
            $varient=Varient::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($varient)
      

            
            
//toggle button
             ->addColumn('status', function (Varient $varient) {

                return '
                 <span
                         id="status-label-'.$varient->id.'" 
                          class=" '.( $varient->status ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ).' ">
                            '.($varient->status ? 'Active' : 'Inactive' ).'
                 </span>
                       
                        <div class="form-check form-switch">
                                     <input 
                                          class="form-check-input toggle-status"
                                          type="checkbox"
                                          name="status"
                                          data-id="'.$varient->id.'"  '.($varient->status ? 'checked' : '').'>
                         </div>';
            })



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
                                                              <i class="bi-trash-fill btn btn-outline-danger btn btn-sm "></i>
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



      public function update(Request $request, $id)
    {
        $request->validate([
          'size'      => 'required|string|max:25',
          'color'      => 'required|string|max:25',
          'stock'      => 'required|integer|min:0|max:50',
          'status'    => 'nullable|boolean',
        ]);

        Varient::where('id', $id)->update([
             'size' => $request->size,
             'color' => $request->color,
             'stock' => $request->stock,
        ]);
        return redirect()
            ->route('admin.varient_management.show_varient')
            ->with('success', 'Varient updated successfully');
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
