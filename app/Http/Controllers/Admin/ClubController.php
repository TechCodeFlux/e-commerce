<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Club;
use App\Models\Country;
use App\Models\State;

class ClubController extends Controller
{
    /**
     * LIST CLUBS
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $club = Club::query()
                ->leftJoin('countries', 'countries.id', '=', 'clubs.country_id')
                ->leftJoin('states', 'states.id', '=', 'clubs.state_id')
                ->select([
                    'clubs.*',
                    'countries.name as country_name',
                    'states.name as state_name'
                ]);

            return datatables()
                ->eloquent($club)
                ->addColumn('action', function (Club $club) {

                    return '
                        <a href="'.route('admin.clubs.dashboard', $club->id).'" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.editclub', $club->id).'" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                        <button data-id="'.$club->id.'" class="btn btn-sm btn-danger delete-club"><i class="fas fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.club.clubview');
    }


    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $clubuser = new Club();
        $countries = Country::orderBy('name')->get();

        return view('admin.club.form', compact('clubuser', 'countries'));
    }


    /**
     * STORE CLUB (ADD CLUB)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|regex:/^[A-Za-z\s]+$/',
            'address'   => 'required|string',
            'contact'   => 'required|string|max:20|digits_between:1,10',
            'email'     => 'required|email|unique:clubs,email',
            'country'   => 'required|integer|exists:countries,id',
            'state'     => 'required|integer|exists:states,id',
            'city'      => 'required|string|max:100',
            'zip_code'  => 'required|digits:6',
            'status'    => 'nullable|boolean',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $randomPassword = Str::random(8);

        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club_images', 'public');
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

        return redirect()
            ->route('admin.clubsindex')
            ->with('success', 'Club registered successfully!');
    }


    /**
     * EDIT FORM
     */
    public function edit($id)
    {
        $clubuser = Club::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $clubuser->country_id)->get();

        return view('admin.club.form', compact('clubuser', 'countries', 'states'));
    }


    /**
     * UPDATE CLUB
     */
    public function update(Request $request, Club $club)
    {
        $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'contact'   => 'required|string',
            'email'     => 'required|email',
            'country'   => 'required|integer|exists:countries,id',
            'state'     => 'required|integer|exists:states,id',
            'city'      => 'required|string',
            'zip_code'  => 'required',
            'status'    => 'nullable|boolean',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $club->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club_images', 'public');
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
     * DELETE CLUB
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return response()->json([
            'success' => true,
            'message' => 'Club deleted successfully'
        ]);
    }


    /**
     * CLUB DASHBOARD
     */
    public function dashboard(Club $club)
    {
        return view('admin.club.detail', compact('club'));
    }


    /**
     * PROFILE PAGE
     */
    public function profile($id)
    {
        $club = Club::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();

        return view('admin.club.profile', compact('club', 'countries', 'states'));
    }


    public function getStates($countryId)
{
    return response()->json(
        State::where('country_id', $countryId)
            ->orderBy('name')
            ->get(['id', 'name'])
    );
}

    /**
     * UPDATE PROFILE
     */
    public function editprofile(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $request->validate([
            'name'      => 'required|string',
            'address'   => 'required|string',
            'contact'   => 'required|string',
            'email'     => 'required|email',
            'country'   => 'required|integer|exists:countries,id',
            'state'     => 'required|integer|exists:states,id',
            'city'      => 'required|string',
            'zip_code'  => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $club->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('club_images', 'public');
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
            'image'      => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}

