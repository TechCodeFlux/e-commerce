<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller  
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

    $options = Option::query()
        ->select([
            'options.id',
            'options.name',
            'options.status',
            'options.created_at'
        ]);

    return datatables()
        ->eloquent($options)

        ->addColumn('status', function ($option) {

    $checked = $option->status ? 'checked' : '';

    return '
        <div class="form-check form-switch">
            <input class="form-check-input toggle-status"
                type="checkbox"
                data-id="delete_option('.$option->id.') "
                '.$checked.'>
        </div>
    ';
})
->rawColumns(['status','action'])


        ->addColumn('action', function (Option $option) {

            $actions = '<div class="d-flex gap-1">';

            // Edit
            $actions .= '<a href="'.route('admin.editoption', $option->id).'" 
                class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>';

            // Delete
            $actions .= '<button type="button" 
                class="btn btn-sm btn-outline-danger delete-option"
                data-id="' . $option->id . '"
                data-bs-toggle="modal"
                data-bs-target="#delete-modal"
                title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>';

            $actions .= '</div>';

            return $actions;
        })

        ->rawColumns(['status','action'])
        ->make(true);
    }

    return view('admin.option_management.show_option');

    }
    //change status
    public function changeStatus(Request $request)
    {
        $option = Option::find($request->id);
        if ($option) {
            $option->status = $request->status;
            $option->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Option not found.'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option = new Option(); // empty model
        return view('admin.option_management.add_option', compact('option'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'Option name is required',
            'name.regex' => 'Only letters and spaces allowed',
        ]);

        Option::create([
            'name'   => $validated['name'],
            'status' => $validated['status'] ?? 0,
        ]);

        return redirect()
            ->route('admin.show_option')
            ->with('success', 'Options registered successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $option = Option::findOrFail($id);
        return view('admin.option_management.add_option', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
{
    $option = Option::findOrFail($id);
    // dd($option);
    $validated = $request->validate([
        'name'   => 'required|string',
        'status' => 'nullable|boolean'
    ]);

    $option->update([
        'name'   => $validated['name'],
        'status' => $validated['status'] ?? 0,
    ]);

    return redirect()
        ->route('admin.show_option')
        ->with('success', 'Option updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return redirect()
            ->route('admin.show_option')
            ->with('success', 'Option deleted successfully!');
    }
}
