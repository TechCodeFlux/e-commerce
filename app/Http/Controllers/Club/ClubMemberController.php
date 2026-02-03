<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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
        return view('club.clubmembers.clubmemberview');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'email'   => 'required|email|unique:club_members,email',
            'status'  => 'nullable|boolean',
        ]);

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
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'email'   => [
                'required',
                'email',
                Rule::unique('club_members')->ignore($clubmember->id),
            ],
            'status'  => 'nullable|boolean',
        ]);

        $clubmember->update([
            'name'    => $request->name,
            'address' => $request->address,
            'email'   => $request->email,
            'status'  => $request->has('status'),
        ]);

        return redirect()
            ->route('club.clubmembers.index')
            ->with('success', 'Club Member updated successfully!');
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
