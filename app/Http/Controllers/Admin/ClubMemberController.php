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
use App\Models\ClubMember;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;

class ClubMemberController extends Controller
{
    public function viewmembers(Request $request, Club $club)
   {
         if($request->ajax()){
            $clubmember = ClubMember::where('club_id', $club->id);
            // return DataTables::eloquent($club)
            return datatables()
            ->eloquent($clubmember)
            ->addColumn('address', fn ($row) => optional($row->address)->address1 ?? '--')
            ->addColumn('zip_code', fn ($row) => optional($row->address)->zip_code ?? '--')
            ->addColumn('country', fn ($row) => optional($row->address?->country)->name ?? '--')
            ->addColumn('state', fn ($row) => optional($row->address?->state)->name ?? '--')

            ->addColumn('city', fn ($row) => optional($row->address)->city ?? '--')
             ->addColumn('club', fn ($row) => optional($row->club)->name ?? '--')
            ->addColumn('action', function (ClubMember $clubmember) {
                return '
                    <div class="d-flex gap-1">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" title="Show">
                            <i class="fas fa-eye text-warning"></i>
                        </a>
                        <a href="'. route('admin.clubmember.editmember',$clubmember->id).'" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="'. route('admin.clubmember.deletemember',$clubmember->id).'" class="btn btn-sm btn-outline-danger" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.clubmember.viewmember', compact('club'));
   }



   public function addmember($id)
    {
        $club = Club::findOrFail($id);
        $clubmember = new ClubMember();
        $countries = Country::orderBy('name')->get();
        // $state=State::all();
        $message=" ";
        return view('admin.clubmember.addmember', compact('club','clubmember','message','countries'));
    }

    public function storemember(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|regex:/^[A-Za-z\s]+$/',
            'address' => 'required|string',
            'contact' => 'required|string|max:10',
            'email'   => 'required|email',
            'country' =>'required|integer',
            'state'   => 'required|max:100',
            'city'    => 'required|string|max:100',
            'zip_code' =>'required|integer',
            'status'  => 'nullable|boolean',
        ]);

        // 1️⃣ Create club member first
        $clubmember = ClubMember::create([
            'name'    => $request->name,
            'contact' => $request->contact,
            'email'   => $request->email,
            'club_id' => $id,
            'address_id'=> 0,
            'status'  => 1,
        ]);

        // 2️⃣ Create address with club_member_id
       $address = Address::create([
            'address1'       => $request->address,
            'country_id'       => $request->country,
            'state_id'          => $request->state,
            'country_id'        =>$request->country,
            'city'           => $request->city,
            'zip_code'       => $request->zip_code,
            'status'         => 1,
        ]);

        // 3️⃣ Update member with address_id
        $clubmember->update([
            'address_id' => $address->id,
        ]);

         

        return redirect()
            ->route('admin.clubmember.viewmembers', $id)
            ->with('success', 'Club member added successfully');
    }

    public function editmember($id)
{
    $clubmember = ClubMember::findOrFail($id);
    $club = Club::findOrFail($clubmember->club_id);
    $countries = Country::orderBy('name')->get();

    $address = Address::find($clubmember->address_id); // returns null if not found

    // preload states only if country exists
    $states = [];
    if ($address && $address->country_id) {
        $states = State::where('country_id', $address->country_id)->orderBy('name')->get();
    }

    return view(
        'admin.clubmember.addmember',
        compact('clubmember', 'club', 'address', 'countries', 'states')
    );
}

    public function updatemember(Request $request,$id)
    {
         $request->validate([
            'name'    => 'required|regex:/^[A-Za-z\s]+$/',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'email'   => 'required|email',
            'state'   => 'required|string|max:100',
            'city'    => 'required|string|max:100',
            'zip_code' =>'required|digits:6',
            'status'  => 'nullable|boolean',
        ]);

        $clubmember=ClubMember::findorfail($id);
        $address = Address::findOrFail($clubmember->address_id);
        $club = Club::findOrFail($clubmember->club_id); 

        $clubmember->update([
            'name'    => $request->name,
            'contact' => $request->contact,
            'email'   => $request->email,
        ]);

        $address->update([
            'address1'       => $request->address,
            'country_id'     =>$request->country,
            'state_id'        => $request->state,
            'city'           => $request->city,
            'zip_code'       => $request->zip_code,
            
        ]);
    
        return view('admin.clubmember.viewmember', compact('club'));
    }

    public function deletemember($id)
    {
        $clubmember = Clubmember::findOrFail($id);
        $clubmember->delete(); 
        return redirect()->back()->with('success', 'club member as deleted successfully');
    }
}
