<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;

class ClubMemberController extends Controller
{

    // ================= ADMIN — VIEW MEMBERS =================

    public function index(Request $request, Club $club)
    {
        if ($request->ajax()) {

            $clubmember = ClubMember::where('club_id', $club->id);

            return datatables()
                ->eloquent($clubmember)
                ->addColumn('club', fn ($row) => optional($row->club)->name ?? '--')
                ->addColumn('address', fn ($row) => optional($row->address)->address1 ?? '--')
                ->make(true);
        }

        return view('admin.clubmember.viewmember', compact('club'));
    }


    // ================= ADMIN — ADD MEMBER FORM =================

    public function addmember($id)
    {
        $club = Club::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return view('admin.clubmember.addmember', compact('club', 'countries'));
    }


    // ================= ADMIN — STORE MEMBER (CREATES LOGIN USER) =================

    public function storemember(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'contact'  => 'required',
            'email'    => 'required|email|unique:club_members,email',
            'password' => 'required|min:6', // REQUIRED FOR LOGIN
            'address'  => 'required|string',
            'country'  => 'required|integer',
            'state'    => 'required|integer',
            'city'     => 'required|string',
            'zip_code' => 'required'
        ]);

        // Create Address
        $address = Address::create([
            'address1'   => $request->address,
            'country_id' => $request->country,
            'state_id'   => $request->state,
            'city'       => $request->city,
            'zip_code'   => $request->zip_code,
            'status'     => 1,
        ]);

        // Create Club Member (Login User)
        ClubMember::create([
            'name'       => $request->name,
            'contact'    => $request->contact,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), // 🔐 HASHED
            'club_id'    => $id,
            'address_id' => $address->id,
            'status'     => 1,
        ]);

        return redirect()
            ->route('admin.clubmember.viewmembers', $id)
            ->with('success', 'Club member added successfully');
    }


    // ================= ADMIN — EDIT MEMBER =================

    public function editmember($id)
    {
        $clubmember = ClubMember::findOrFail($id);
        $club = Club::findOrFail($clubmember->club_id);
        $countries = Country::orderBy('name')->get();
        $address = Address::find($clubmember->address_id);

        $states = [];
        if ($address && $address->country_id) {
            $states = State::where('country_id', $address->country_id)->get();
        }

        return view('admin.clubmember.addmember',
            compact('clubmember', 'club', 'address', 'countries', 'states')
        );
    }


    // ================= ADMIN — UPDATE MEMBER =================

    public function updatemember(Request $request, $id)
    {
        $clubmember = ClubMember::findOrFail($id);
        $address = Address::findOrFail($clubmember->address_id);

        $clubmember->update([
            'name'    => $request->name,
            'contact' => $request->contact,
            'email'   => $request->email,
        ]);

        $address->update([
            'address1'   => $request->address,
            'country_id' => $request->country,
            'state_id'   => $request->state,
            'city'       => $request->city,
            'zip_code'   => $request->zip_code,
        ]);

        return redirect()
            ->route('admin.clubmember.viewmembers', $clubmember->club_id)
            ->with('success', 'Member updated successfully');
    }


    // ================= ADMIN — DELETE MEMBER =================

    public function deletemember($id)
    {
        ClubMember::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Club member deleted successfully');
    }



    // =========================================================
    // 🔐 CLUB MEMBER LOGIN SECTION
    // =========================================================

    public function showLogin()
    {
        return view('clubmember.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('clubmember')->attempt($credentials)) {
            return redirect()->route('clubmember.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ]);
    }

    public function logout()
    {
        Auth::guard('clubmember')->logout();
        return redirect()->route('clubmember.login');
    }
}