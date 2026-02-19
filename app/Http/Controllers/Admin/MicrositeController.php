<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
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
                $actions .= '<a href="" class="btn btn-sm btn-clean btn-icon" title="Show">
                                <i class="fas fa-eye" style="color: #ffc107;"></i>
                             </a>';
                $actions .= '<a href="" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                             </a>';
                $actions .= '<button type="button" 
                                class="btn btn-sm btn-outline-danger delete-microsite"
                                data-id="' . $microsite->id . '"
                                data-bs-toggle="modal"
                                data-bs-target="#delete-modal"
                                title="Delete">
                                <i class="fas fa-trash-alt"></i>
                             </button>';
                $actions .= '</div>';

                return $actions;
            })
            ->rawColumns(['microsite_status','status','action'])
            ->make(true);
    }

    // pass the Club object to the view, NOT its ID
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
        return view('admin.microsite_management.add_microsite', compact('club'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Microsite $microsite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Microsite $microsite)
    {
        //
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
