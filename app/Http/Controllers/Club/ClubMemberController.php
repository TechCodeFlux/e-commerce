<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ClubMember;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;


class ClubMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $members = ClubMember::query();

            return DataTables::eloquent($members)
                ->addColumn('action', function (ClubMember $member) {

                    $actions = '<div class="d-flex gap-1">';

                    $actions .= '<a href="' . route('club.clubmembers.edit', $member->id) . '"
                        class="btn btn-sm btn-outline-secondary" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>';

                    $actions .= '<button type="button"
                        class="btn btn-sm btn-outline-danger"
                        onclick="deleteMember(' . $member->id . ')">
                        <i class="fas fa-trash-alt"></i>
                    </button>';

                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('club.clubmembers.clubmemberview');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clubmember = new ClubMember();
        $countries = Country::orderBy('name')->get();
        return view('club.clubmember.form', compact('clubmember', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1️⃣ Validate input
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:club_members,email',
        'contact'   => 'required|string|max:20',
        'address1'  => 'required|string|max:255',
        'address2'  => 'nullable|string|max:255',
        'country'   => 'required|integer|exists:countries,id',
        'state'     => 'required|integer|exists:states,id',
        'city'      => 'required|string|max:100',
        'zip_code'  => 'required|string|max:10',
        'status'    => 'nullable|boolean',
    ]);

    try {
        // 2️⃣ Start transaction
        DB::transaction(function () use ($validated, $request) {

            // 2a️⃣ Create the address first
            $address = Address::create([
                'address1'   => $validated['address1'],
                'address2'   => $validated['address2'] ?? null,
                'country_id' => $validated['country'],
                'state_id'   => $validated['state'],
                'city'       => $validated['city'],
                'zip_code'   => $validated['zip_code'],
            ]);

            // 2b️⃣ Create the club member with address_id
            $member = ClubMember::create([
                'name'       => $validated['name'],
                'club_id'    => 6, // hardcoded, or $validated['club_id'] if dynamic
                'contact'    => $validated['contact'],
                'email'      => $validated['email'],
                'status'     => $request->boolean('status'),
                'address_id' => $address->id,
            ]);
        });

        // 3️⃣ Redirect on success
        return redirect()
            ->route('club.clubmembersindex')
            ->with('success', 'Club member registered successfully!');

    } catch (\Throwable $e) {
        // 4️⃣ Show error if something fails
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}




        ClubMember::create([
            'name'    => $request->name,
            'address' => $request->address,
            'email'   => $request->email,
            'status'  => $request->has('status'),
        ]);

        return redirect()
            ->route('club.clubmembers.index')
            ->with('success', 'Club Member registered successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClubMember $clubmember)
    {
        return view('club.clubmembers.clubmemberview', compact('clubmember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClubMember $clubmember)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubMember $clubmember)
    {
        $clubmember->delete();

        return response()->json(['success' => true]);
    }
}
