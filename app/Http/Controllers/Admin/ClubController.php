<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;

//datatables
use App\Models\Club;


class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if($request->ajax()){
            $club=Club::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($club)
            ->addColumn('action', function (Club $club) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';
                $actions .= '<a href="' . route('admin.clubsindex', $club->id) . '" class="btn btn-sm btn-clean btn-icon" title="Show"><i class="fas fa-eye" style="color: #ffc107;"></i></a>';
                // ' . route('admin.clubs.edit', $club->id) . '
                 $actions .= '<a href="" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                 </a>';

                

                $actions .= '<button type="button" class="btn btn-sm btn-outline-danger delete-club" onclick="deleteClub(' . $club->id . ')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>';
                
              

                $actions .= '</div>';
                return  $actions;
            })->rawColumns(['action'])->make(true);
        }

        return view('admin.club.clubview');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clubuser = Auth::guard('admin')->user();
        return view('admin.club.form', compact('clubuser'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'club_name'    => 'required|string|max:255',
        'club_address' => 'required|string',
        'club_contact' => 'required|string|max:20',
        'email'        => 'required|email|unique:clubs,email',
        'country_id'   => 'required|integer',
        'state_id'     => 'required|string|max:100',
        'city'         => 'required|string|max:100',
        'zip_code'     => 'required|string|max:10',
        'status'       => 'required',//'nullable',
    ]);

        $randomPassword = Str::random(8);

        Club::create([
            'name' => $request->club_name,
            'address' => $request->club_address,
            'contact' => $request->club_contact,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'status' => $request->has('status'),
            'password'    => Hash::make($randomPassword),
        ]);
        return redirect()->back()->with('success', 'Club registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $request->validate([
            'club_name'    => 'required|string|max:255',
            'club_address' => 'required|string',
            'club_contact' => 'required|string|max:20',
            'email'        => 'required|email',
        ]);

        Club::update([
            'name'       => $request->club_name,
            'address'    => $request->club_address,
            'contact'    => $request->club_contact,
            'email'      => $request->email,
            'country_id' => $request->country_id,
            'state_id'   => $request->state_id,
            'city'       => $request->city,
            'zip_code'   => $request->zip_code,
            'status'     => $request->has('status'),
        ]);

        return redirect()
            ->route('admin.club.index')
            ->with('success', 'Club updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        //
    }
}
