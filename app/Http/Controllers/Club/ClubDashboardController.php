<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ClubMember;

class ClubDashboardController extends Controller
{
    public function dashboard()
    {
        $club = Auth::guard('club')->user();
        return view('club.dashboard', compact('club'));
    }


   public function index(Request $request)
{
    $clubId = Auth::guard('club')->id();

    if ($request->ajax()) {

        $members = ClubMember::query()
            ->where('club_id', $clubId)
            ->leftJoin('countries', 'countries.id', '=', 'club_members.country_id')
            ->leftJoin('states', 'states.id', '=', 'club_members.state_id')
            ->select([
                'club_members.*',
                'countries.name as country',
                'states.name as state'
            ]);

        return datatables()
            ->eloquent($members)
            ->addColumn('action', function ($member) {

                return '
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="deletemember('.$member->id.')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('club.members.index');
}
}
