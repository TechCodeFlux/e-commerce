<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\option;

class ClubDashboardController extends Controller
{
    public function index()
    {
        return view('admin.club.dashboard');
    }
    public function store(Request $request)
    {
        $request->validate([
            'option_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Option::create([
            'option_name' => $request->option_name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('club.option.index')
            ->with('success', 'Option added successfully');
    }

    /**
     * Edit option
     */
    public function edit(option $option)
    {
        return view('club.option.edit', compact('option'));
    }

    /**
     * Update option
     */
    public function update(Request $request, option $option)
    {
        $request->validate([
            'option_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $option->update($request->only('option_name', 'status'));

        return redirect()
            ->route('club.option.index')
            ->with('success', 'Option updated successfully');
    }

    /**
     * Delete option
     */
    public function destroy(option $option)
    {
        $option->delete();

        return redirect()
            ->route('club.option.index')
            ->with('success', 'Option deleted successfully');
    }

  
}

