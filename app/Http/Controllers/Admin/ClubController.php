<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
//mail
use App\Mail\ClubMail;
use Illuminate\Support\Facades\Mail;
//datatables
use App\Models\Club;
use App\Models\Country;
use App\Models\State;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
         if($request->ajax()){
            $club = Club::query()
            ->leftJoin('countries', 'countries.id', '=', 'clubs.country_id')
            ->leftJoin('states', 'states.id', '=', 'clubs.state_id')
            ->select([
                'clubs.*',
                'countries.name as country_name',
                'states.name as state_name'
    ]);
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($club)
            ->addColumn('action', function (Club $club) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';
                //view button
                $actions .= '<a href="' . route('admin.clubs.dashboard', $club->id) . '" class="btn btn-sm btn-outline-warning me-2" title="Show"><i class="fas fa-eye" ></i></a>';
                //edit button
                $actions .= '<a href="' . route('admin.editclub', $club->id) . '" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                 </a>';
                //delete button
                $actions .= '<button type="button" class="btn btn-sm btn-outline-danger delete-club" data-id="'.$club->id.'"data-bs-toggle="modal"
                            data-bs-target="#delete-modal" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                
              

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
        $clubuser = new Club(); // empty model
        $countries = Country::orderBy('name')->get();
        return view('admin.club.form', compact('clubuser','countries'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'      =>'required|string|regex:/^[A-Za-z\s]+$/',
    
        'address'   => 'required|string',
        'contact'   => 'required|string|max:20|digits_between:1,10',
        'email'     => 'required|email|unique:clubs,email',

        'country'   => 'required|integer|exists:countries,id',
        'state'     => 'required|integer|exists:states,id',

        'city'      => 'required|string|max:100',
        'zip_code' => 'required|digits:6',
        'status'    => 'nullable|boolean',
        'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $randomPassword = Str::random(8);

    $imagePath = null;

    if ($request->hasFile('image')) 
    {
        $imagePath = $request->file('image')->store('club_profile_images', 'public');
    }

    Club::create([
        'name'       => $request->name,
        'address'    => $request->address,
        'contact'    => $request->contact,
        'email'      => $request->email,

        'country_id' => $request->country,
        'state_id'   => $request->state,

        'city'       => $request->city,
        'zip_code'   => $request->zip_code,
        'status'     => $request->has('status'),
        'password'   => Hash::make($randomPassword),
        'image'      => $imagePath,
    ]);

    Mail::to($request->email)->send(new ClubMail($randomPassword, $request->email));
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Club registered successfully!'
        ]);
    }

    return redirect()
        ->route('admin.clubsindex')
        ->with('success', 'Club registered successfully!');
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
    public function edit($id)
    {
        $clubuser = Club::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $clubuser->country_id)->get();
        return view('admin.club.form', compact('clubuser','countries','states'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $request->validate([
    'name'    => 'required|regex:/^[A-Za-z\s\.\-]+$/',
    'address' => 'required|string',
    'contact' => 'required|regex:/^\+?[1-9]\d{6,14}$/',
    'email'   => [
                    'required',
                    'email',        
                ],
    'country'   => 'required|integer|exists:countries,id',
    'state'     => 'required|integer|exists:states,id',
    'city'      => 'required|string|max:100',
    'zip_code'  => 'required|regex:/^[A-Za-z0-9\-\s]{3,10}$/',
    'status'    => 'nullable|boolean',
    'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
    
    $imagePath = $club->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club_profile_images', 'public');
        }

        $club->update([
        'name'       => $request->name,
        'address'    => $request->address,
        'contact'    => $request->contact,
        'email'      => $request->email,
        'country_id' => $request->country,
        'state_id'   => $request->state,
        'city'       => $request->city,
        'zip_code'   => $request->zip_code,
        'status'     => $request->has('status'),
        'image'      => $imagePath,
    ]);

        return redirect()
            ->route('admin.clubsindex')
            ->with('success', 'Club updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
         $club->delete();

         return response()->json([
        'success' => true,
        'message' => 'Club deleted successfully'
        ]);
    }
    // Get states based on country ID
    public function getStates($countryId)
    {
        return response()->json(
        State::where('country_id', $countryId)
            ->orderBy('name')
            ->get(['id', 'name'])
        );;
    }

    public function dashboard(Club $club)
    {
        return view('admin.club.detail', compact('club'));
    }

    public function profile($id)
    {
        $club=Club::findorfail($id);
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('admin.club.profile',compact('club','countries','states'));
    }

    public function editprofile(Request $request,$id)
    {

        $club=Club::findorfail($id);
        // $countries = Country::orderBy('name')->get();
        // $states = State::orderBy('name')->get();
         $request->validate([
            'name'    => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'address' => 'required|string',
            'contact' => 'required|regex:/^\+?[1-9]\d{6,14}$/',
            'email'   => [
                            'required',
                            'email',        
                        ],
            'country'   => 'required|integer|exists:countries,id',
            'state'     => 'required|integer|exists:states,id',
            'city'      => 'required|string|max:100',
            'zip_code'  => 'required|regex:/^[A-Za-z0-9\-\s]{3,10}$/',
            'status'    => 'nullable|boolean',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $imagePath = $club->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club_profile_images', 'public');
        }
        
                $club->update([
                'name'       => $request->name,
                'address'    => $request->address,
                'contact'    => $request->contact,
                'email'      => $request->email,
                'country_id' => $request->country,
                'state_id'   => $request->state,
                'city'       => $request->city,
                'zip_code'   => $request->zip_code,
                'status'     => $request->has('status'),
                'image'      => $imagePath,
            ]);

        
        return redirect()
        ->route('admin.club.profile', $club->id) // or profile route
        ->with('success', 'Profile updated successfully!');
    }
    

}