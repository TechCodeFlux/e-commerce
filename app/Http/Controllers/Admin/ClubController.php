<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Club;
use App\Models\Country;
use App\Models\State;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::eloquent(Club::query())
                ->addColumn('action', function (Club $club) {
                    return '
                        <a href="' . route('admin.editclub', $club->id) . '" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <form action="' . route('admin.deleteclub', $club->id) . '" method="POST" style="display:inline-block">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Delete this club?\')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
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
        $clubuser = new Club(); // 🔥 REQUIRED for form blade
        $countries = Country::orderBy('name')->get();

        return view('admin.club.form', compact('clubuser', 'countries'));
    }

    /**
     * STORE CLUB
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'regex:/^[A-Za-z ]+$/'],
            'email'   => ['required', 'email', 'max:255'],
            'contact' => ['required', 'regex:/^[2-9][0-9]{2}[2-9][0-9]{6}$/'], // US phone
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'exists:countries,id'],
            'state'   => ['required', 'exists:states,id'],
            'city'    => ['required', 'string', 'max:100'],
            'zip_code'=> ['required', 'regex:/^\d{5}(-\d{4})?$/'], // US ZIP
            //  dd('STORE METHOD HIT', $request->all())
        ]);

        Club::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'contact'    => $validated['contact'],
            'address'    => $validated['address'],
            'country_id' => $validated['country'],
            'state_id'   => $validated['state'],
            'city'       => $validated['city'],
            'zip_code'   => $validated['zip_code'],
            'status'     => $request->has('status') ? 1 : 0,
            'password'   => Hash::make(Str::random(8)),
        ]);

        return redirect()->route('admin.clubsindex')
            ->with('success', 'Club registered successfully!');
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit(Club $club)
    {
        $clubuser = $club; // 🔥 make variable match form blade
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $club->country_id)->get();

        return view('admin.club.form', compact('clubuser', 'countries', 'states'));
    }

    /**
     * UPDATE CLUB
     */
    public function update(Request $request, Club $club)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', Rule::unique('clubs')->ignore($club->id)],
            'contact' => ['required', 'regex:/^[2-9][0-9]{2}[2-9][0-9]{6}$/'],
            'address' => ['required', 'string'],
            'country' => ['required', 'exists:countries,id'],
            'state'   => ['required', 'exists:states,id'],
            'city'    => ['required', 'string', 'max:100'],
            'zip_code'=> ['required', 'regex:/^\d{5}(-\d{4})?$/'],
        ]);

        $club->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'contact'    => $validated['contact'],
            'address'    => $validated['address'],
            'country_id' => $validated['country'],
            'state_id'   => $validated['state'],
            'city'       => $validated['city'],
            'zip_code'   => $validated['zip_code'],
            'status'     => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.clubsindex')
            ->with('success', 'Club updated successfully');
    }

    /**
     * DELETE CLUB
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()->route('admin.clubsindex')
            ->with('success', 'Club deleted successfully');
    }

    /**
     * AJAX — STATES BY COUNTRY
     */
    public function getStates($countryId)
    {
        return response()->json(
            State::where('country_id', $countryId)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}
