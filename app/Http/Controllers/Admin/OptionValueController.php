<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Models\Option;

class OptionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $optionValues = OptionValue::query()
                ->leftJoin('options', 'options.id', '=', 'option_values.option_value_id') // ← change if needed
                ->select([
                    'option_values.*',
                    'options.name as option_name'
                ]);

            return datatables()
                ->eloquent($optionValues)

                // ✅ Toggle Switch Column
                ->addColumn('status', function ($option) {

                    $checked = $option->status ? 'checked' : '';

                    return '
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-status"
                                type="checkbox"
                                data-id="' . $option->id . '"
                                ' . $checked . '>
                        </div>
                    ';
                })

                // ✅ Action Buttons Column
                ->addColumn('action', function ($optionValues) {

                    $actions = '<div class="d-flex gap-1">';

                    // Edit
                    // $actions .= '
                    //     <a href="' . route('admin.edit_option_value', $row->id) . '" 
                    //     class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                    //         <i class="fas fa-pencil-alt"></i>
                    //     </a>
                    // ';

                    // Delete
                   $actions .= '
                            <button 
                                class="btn btn-sm btn-outline-danger delete-btn"
                                data-id="' . $optionValues->id . '"
                                title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        ';

                    $actions .= '</div>';

                    return $actions;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.option_value_management.show_option_value');
    }

    public function changeStatus(Request $request)
    {
        $optionvalue = OptionValue::find($request->id);
        if ($optionvalue) {
            $optionvalue->status = $request->status;
            $optionvalue->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Option value not found.'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option_value = new OptionValue(); // empty model
        $option_value_list = Option::where('status', 1)
        ->orderBy('name')
        ->get();
        return view('admin.option_value_management.add_option_value', compact('option_value','option_value_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'option_id' => 'required|exists:options,id',
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'Option value name is required',
            'name.regex' => 'Only letters and spaces allowed',
        ]);

        OptionValue::create([
            'name' => $validated['name'],
            'option_value_id' => $validated['option_id'],
            'status' => $validated['status'] ?? 0,
        ]);

        return redirect()
            ->route('admin.show_option_value')
            ->with('success', 'Option Value registered successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(OptionValue $optionValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionValue $optionValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OptionValue $optionValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $optionValue = OptionValue::findOrFail($id);
        $optionValue->delete();

        return response()->json(['success' => 'Option value deleted successfully.']);
    }
}
