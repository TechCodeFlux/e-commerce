<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Microsite;
use App\Models\Club;
use Illuminate\Http\Request;

class MicrositeController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request, Club $club)
    {
        if ($request->ajax()) {

            $microsites = Microsite::query()
                ->where('club_id', $club->id) // use $club->id here
                ->select([
                    'microsites.id',
                    'microsites.name',
                    'microsites.start_date',
                    'microsites.end_date',
                    'microsites.image',
                    'microsites.status',
                    'microsites.created_at'
                ]);

            return datatables()
                ->eloquent($microsites)
                ->editColumn('start_date', fn($m) => $m->start_date->format('d M Y'))
                ->editColumn('end_date', fn($m) => $m->end_date->format('d M Y'))
                ->addColumn('microsite_status', function ($microsite) {

                    $today = Carbon::today();

                    if ($today->lt($microsite->start_date)) {
                        return '<span class="badge bg-warning">Upcoming</span>';
                    }

                    if ($today->between($microsite->start_date, $microsite->end_date)) {
                        return '<span class="badge bg-success">Active</span>';
                    }

                    return '<span class="badge bg-danger">Expired</span>';
                })
                ->addColumn('status', function ($microsite) {

                    $checked = $microsite->status ? 'checked' : '';

                    return '
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-status"
                                type="checkbox"
                                data-id="'.$microsite->id.'"
                                '.$checked.'>
                        </div>
                    ';
                })
                ->addColumn('action', function ($microsite) {

                    $actions = '<div class="d-flex gap-1">';
                    $actions .= '<button class="btn btn-sm btn-clean btn-icon showMicrosite" data-id="'.$microsite->id.'" title="Show">
                        <i class="fas fa-eye" style="color: #ffc107;"></i></button>';
                    $actions .= '<a href="' . route('admin.editmicrosite', $microsite->id) . '" class="btn btn-sm btn-outline-secondary 
                        me-2" title="Edit"><i class="fas fa-pencil-alt"></i></a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-outline-danger delete-microsite" data-id="' . $microsite->id . 
                        '"data-bs-toggle="modal" data-bs-target="#delete-modal" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['microsite_status','status','action'])
                ->make(true);
        }
        return view('admin.microsite_management.show_microsite', compact('club'));
    }

    public function changeStatus(Request $request)
    {
        $microsite = Microsite::find($request->id);
        if ($microsite) {
            $microsite->status = $request->status;
            $microsite->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Microsite not found.'], 404);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($clubId)
    {
        $club = Club::findOrFail($clubId);
        $microsite = new Microsite();
        return view('admin.microsite_management.add_microsite', compact('club', 'microsite'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'description' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'club_id'     => 'required|exists:clubs,id',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'Microsite name is required',
            'name.regex' => 'Only letters and spaces allowed',
            'description.required' => 'Microsite description is required',
            'description.regex' => 'Only letters and spaces allowed',
            'start_date.required' => 'Microsite start date is required',
            'end_date.required' => 'Microsite end date is required',
            'club_id.required'     => 'Club ID is required',
        ]);

        if (!$request->hasFile('image')) {
            dd('File not received');
        }

        $imagePath = $request->file('image')
                         ->store('microsite_images', 'public');

        Microsite::create([
            'name'   => $validated['name'],
            'description'   => $validated['description'],
            'start_date'   => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'club_id'   => $validated['club_id'],
            'image'       => $imagePath,
            'status' => $validated['status'] ?? 0,
        ]);

        return redirect()
            ->route('admin.show_microsites', $validated['club_id'])
            ->with('success', 'Microsite registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Microsite $microsite)
    {
        $microsite->load('club');

        $today = Carbon::today();

        if ($today->lt($microsite->start_date)) {
            $microsite_status = 'Upcoming';
        } elseif ($today->between($microsite->start_date, $microsite->end_date)) {
            $microsite_status = 'Active';
        } else {
            $microsite_status = 'Expired';
        }

        return response()->json([
            'name' => $microsite->name,
            'description' => $microsite->description,
            'start_date' => Carbon::parse($microsite->start_date)->format('d M Y'),
            'end_date' => Carbon::parse($microsite->end_date)->format('d M Y'),
            'status' => $microsite->status ? 'Active' : 'Inactive',
            'microsite_status' => $microsite_status,
            'club' => $microsite->club->name ?? 'N/A',
            'image' => $microsite->image 
                ? asset('storage/' . $microsite->image) 
                : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $microsite = Microsite::findOrFail($id);
        $club = Club::findOrFail($microsite->club_id);
        return view('admin.microsite_management.add_microsite',compact('microsite', 'club'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Microsite $microsite)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($microsite->image) && Storage::disk('public')->exists($microsite->image)) {
                Storage::disk('public')->delete($microsite->image);
            }
            $imagePath = $request->file('image')->store('microsite_images', 'public');

        } else {
        $imagePath = $microsite->image;
        }
        $microsite->update([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date'    => Carbon::parse($request->end_date)->format('Y-m-d'),
            'image'       => $imagePath,
            'status'      => $request->status ?? 0, // checkbox fallback
        ]);
        return redirect()
            ->route('admin.show_microsites', $microsite->club_id)
            ->with('success', 'Microsite updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Microsite::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }
}
