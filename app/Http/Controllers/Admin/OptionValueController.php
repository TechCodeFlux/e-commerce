<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Option;

class OptionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = new Category();
        $category_list = Category::orderBy('name')->get(); 
        return  view('admin.option_value_management.show_option_value', compact('category','category_list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option_value = new OptionValue(); // empty model
        $option_value_list = Option::orderBy('name')->get();
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
    public function destroy(OptionValue $optionValue)
    {
        //
    }
}
