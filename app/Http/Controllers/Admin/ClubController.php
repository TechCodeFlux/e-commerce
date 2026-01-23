<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

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
            $club=Club::query();
            // return DataTables::eloquent($club)
            return datatables()
    ->eloquent($club)
            ->addColumn('action', function (Club $club) use ($request) {
                $actions= '<div class="d-flex gap-1"><div class="dropdown">';
                //view button
                $actions .= '<a href="' . route('admin.clubsindex', $club->id) . '" class="btn btn-sm btn-clean btn-icon" title="Show"><i class="fas fa-eye" style="color: #ffc107;"></i></a>';
                //edit button
                $actions .= '<a href="' . route('admin.editclub', $club->id) . '" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                 </a>';
                // // delete button
         $actions .= '
        <form action="'.route('admin.deleteclub', $club->id).'" method="POST" 
              style="display:inline-block" 
              onsubmit="return confirm(\'Are you sure you want to delete this club?\')">
            '.csrf_field().'
            '.method_field('DELETE').'
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
        ';
        $actions .= '</div>';
        return $actions;
    })
    ->rawColumns(['action'])
    ->make(true);
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
            'name' => ['required', 'string', 'regex:/^[A-Za-z ]+$/'],
            'email' => ['required', 'email', 'max:255'],
            'contact' => ['required', 'digits_between:7,15'],
            'address' => ['required', 'string'],
            'country' => ['required', 'exists:countries,id'],
            'state' => ['required', 'exists:states,id'],
            'city' => ['required', 'string'],
            'zip_code' => ['required', 'regex:/^\d{5}(-\d{4})?$/']
        ], [
            'name.regex' => 'Name may contain only letters and spaces.',
            'contact.digits_between' => 'Contact must contain numbers only (7-15 digits).',
            'zip_code.regex' => 'ZIP code must be in US format (12345 or 12345-6789).'
    ]);

    $randomPassword = Str::random(8);

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
    ]);

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
    'name' => 'required|string|max:255',
    'address' => 'required|string',
    'contact' => 'required|string|max:20',
    'email' => [
        'required',
        'email',
        Rule::unique('clubs')->ignore($club->id), // ignore current club id
    ],
    'country'   => 'required|integer|exists:countries,id',
        'state'     => 'required|integer|exists:states,id',
    'city' => 'required|string|max:100',
    'zip_code' => 'required|string|max:10',
    'status' => 'nullable|boolean',
]);

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

    return redirect()
        ->route('admin.clubsindex')
        ->with('success', 'Club deleted successfully');
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
}
