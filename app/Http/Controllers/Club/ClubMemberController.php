<?php
namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ClubMemberController extends Controller
{
    public function index(Request $request)
    {
        $club = Auth::guard('club')->user();

        if ($request->ajax()) {
            return DataTables::eloquent(
                ClubMember::where('club_id', $club->id)
            )
            ->addColumn('action', function ($member) {
                return '
                    <a href="'.route('club.members.edit', $member->id).'" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMember('.$member->id.')">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('club.members.index');
    }

    public function create()
    {
        $clubuser = new ClubMember();
        return view('club.members.form', compact('clubuser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:club_members,email',
            'phone' => 'required|string|max:20',
            'status'=> 'boolean',
        ]);

        ClubMember::create([
            'club_id' => Auth::guard('club')->id(),
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'state'   => $request->state,
            'city'    => $request->city,
            'zip_code'=> $request->zip_code,
            'status'  => $request->status,
            'password'=> Hash::make(Str::random(8)),
        ]);

        return redirect()
            ->route('club.members.index')
            ->with('success', 'Club member added successfully');
    }

    public function edit(ClubMember $member)
    {
        // security: prevent cross-club access
        abort_if($member->club_id !== Auth::guard('club')->id(), 403);

        $clubuser = $member;
        return view('club.members.form', compact('clubuser'));
    }

    public function update(Request $request, ClubMember $member)
    {
        abort_if($member->club_id !== Auth::guard('club')->id(), 403);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:club_members,email,' . $member->id,
            'phone' => 'required',
            'status'=> 'boolean',
        ]);

        $member->update($request->only([
            'name','email','phone','address',
            'country','state','city','zip_code','status'
        ]));

        return redirect()
            ->route('club.members.index')
            ->with('success', 'Club member updated successfully');
    }

    public function destroy(ClubMember $member)
    {
        abort_if($member->club_id !== Auth::guard('club')->id(), 403);

        $member->delete();

        return response()->json(['success' => true]);
    }
}
