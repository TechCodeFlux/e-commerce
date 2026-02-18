<?php

namespace App\Http\Controllers\Admin\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Microsite;
use App\Models\Club;

class MicrositeController extends Controller
{
    // Show Create Page
    public function create($clubId)
    {
        $club = Club::findOrFail($clubId);

        return view('admin.club.microform', compact('club'));
    }

    // Store Microsite
    public function store(Request $request)
    {
        $request->validate([
            'club_id'     => 'required|exists:clubs,id',
            'event_name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $bannerPath = null;

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('microsite_banners', 'public');
        }

        Microsite::create([
            'club_id'     => $request->club_id,
            'event_name'  => $request->event_name,
            'description' => $request->description,
            'banner'      => $bannerPath,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        return back()->with('success', 'Microsite created successfully!');
    }
}
