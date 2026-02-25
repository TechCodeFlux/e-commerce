<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;

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
                        <a href="'. route('admin.clubmember.profile',$clubmember->id).'" class="btn btn-sm btn-clean btn-icon" title="Show">
                            <i class="fas fa-eye text-warning"></i>
                        </a>
                        <a href="'. route('admin.clubmember.editmember',$clubmember->id).'" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        
                        <button type="button" class="btn btn-sm btn-outline-danger delete-club" onclick="deletemember(' . $clubmember->id . ')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
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
        $address= new Address();
        // $state=State::all();
        $message=" ";
        return view('admin.clubmember.addmember', compact('club','clubmember','message','countries','address'));
    }

public function storemember(Request $request, $id)
{
    $request->validate([
       'name' => 'required|regex:/^[A-Za-z\\s\\.\\-]+$/',
        'address' => 'required|string',
        'contact' => 'required|string|max:10',
        'email'   => 'required|email',
        'country' =>'required|integer',
        'state'   => 'required|max:100',
        'city'    => 'required|string|max:100',
        'zip_code' =>'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload image FIRST
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')
                         ->store('club_members', 'public');
    } else {
        $imagePath = null; // or set a default image path if you have one
    }

    

    // Create club member
    $clubmember = ClubMember::create([
        'name'    => $request->name,
        'contact' => $request->contact,
        'email'   => $request->email,
        'club_id' => $id,
        'address_id'=> 0,
        'status'  => 1,
        'image' => $imagePath, // SAVE IMAGE PATH
    ]);

    // Create address
    $address = Address::create([
        'address1'  => $request->address,
        'country_id'=> $request->country,
        'state_id'  => $request->state,
        'city'      => $request->city,
        'zip_code'  => $request->zip_code,
        'status'    => 1,
    ]);

    //Update address_id
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
            'name' => 'required|regex:/^[A-Za-z\\s\\.\\-]+$/',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'email'   => 'required|email',
            'state'   => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'city'    => 'required|string|max:100',
            'zip_code' =>'required|digits:6',
            'status'  => 'nullable|boolean',
        ]);

        $clubmember=ClubMember::findorfail($id);
        $address = Address::findOrFail($clubmember->address_id);
        $club = Club::findOrFail($clubmember->club_id); 

         $data = [
                'name'    => $request->name,
                'contact' => $request->contact,
                'email'   => $request->email,
            ];

            // ✅ Only update image if new file uploaded
            if ($request->hasFile('image')) {

                // (Optional) Delete old image
                if ($clubmember->image && Storage::exists('public/' . $clubmember->image)) {
                    Storage::delete('public/' . $clubmember->image);
                }

                $imagePath = $request->file('image')->store('club_members', 'public');
                $data['image'] = $imagePath;
            }

            $clubmember->update($data);

        $address->update([
            'address1'       => $request->address,
            'country_id'     =>$request->country,
            'state_id'        => $request->state,
            'city'           => $request->city,
            'zip_code'       => $request->zip_code,
            
        ]);
    
        // return view('admin.clubmember.viewmember', compact('club'));
        return redirect()
                ->route('admin.clubmember.viewmembers', $club->id)
                ->with('success', 'Updated successfully');
    }

    public function deletemember($id)
    {
        $clubmember = ClubMember::findOrFail($id);
        $clubmember->delete(); 
        return redirect()->back()->with('success', 'club member as deleted successfully');
    }

    public function profile($id)
    {
        $clubmember = ClubMember::findOrFail($id);
        $address = Address::find($clubmember->address_id);
        $club = Club::find($clubmember->club_id);
        $countries = Country::orderBy('name')->get();

        $address = Address::find($clubmember->address_id); // returns null if not found

        // preload states only if country exists
        $states = [];
        if ($address && $address->country_id) {
            $states = State::where('country_id', $address->country_id)->orderBy('name')->get();
        }
        
        return view('admin.clubmember.profile', compact('clubmember', 'address', 'countries', 'states', 'club'));
    }

        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|regex:/^[A-Za-z\\s\\.\\-]+$/',
                'address' => 'required|string',
                'contact' => 'required|string|max:20',
                'email'   => 'required|email',
                'state'   => 'required|string|max:100',
                'city'    => 'required|string|max:100',
                'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'zip_code' =>'required|digits:6',
            ]);

            $clubmember = ClubMember::findOrFail($id);
            $address = Address::findOrFail($clubmember->address_id);

            $data = [
                'name'    => $request->name,
                'contact' => $request->contact,
                'email'   => $request->email,
            ];

            // ✅ Only update image if new file uploaded
            if ($request->hasFile('image')) {

                // (Optional) Delete old image
                if ($clubmember->image && Storage::exists('public/' . $clubmember->image)) {
                    Storage::delete('public/' . $clubmember->image);
                }

                $imagePath = $request->file('image')->store('club_members', 'public');
                $data['image'] = $imagePath;
            }

            $clubmember->update($data);

            $address->update([
                'address1'   => $request->address,
                'country_id' => $request->country,
                'state_id'   => $request->state,
                'city'       => $request->city,
                'zip_code'   => $request->zip_code,
            ]);

            return redirect()
                ->route('admin.clubmember.profile', $id)
                ->with('success', 'Profile updated successfully');
        }

        public function editimage(Request $request, $id)
        {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $member = ClubMember::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($member->image && Storage::exists($member->image)) {
                    Storage::delete($member->image);
                }

                $path = $request->file('image')->store('clubmembers', 'public');
                $member->image = $path;
                $member->save();
            }

            return response()->json([
                'message' => 'Image updated successfully',
                'image_url' => asset('storage/' . $member->image)
            ]);
        }
}