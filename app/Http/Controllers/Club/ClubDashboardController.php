<?php

namespace App\Http\Controllers\Club;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\ClubMemberMail;
use App\Mail\MicrositeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
//datatables
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;
use App\Models\Order;
use App\Models\Microsite;
use App\Models\Category;

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


public function clubmember(Request $request, Club $club)
{
    if ($request->ajax()) {

        $clubmember = ClubMember::with([
            'address.country',
            'address.state',
            'club'
        ])->where('club_id', $club->id);

        return datatables()
            ->eloquent($clubmember)

            ->addColumn('address', fn ($row) => $row->address->address1 ?? '--')
            ->addColumn('zip_code', fn ($row) => $row->address->zip_code ?? '--')
            ->addColumn('country', fn ($row) => $row->address->country->name ?? '--')
            ->addColumn('state', fn ($row) => $row->address->state->name ?? '--')
            ->addColumn('city', fn ($row) => $row->address->city ?? '--')
            ->addColumn('club', fn ($row) => $row->club->name ?? '--')

            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex gap-1">
                        
                       <a href="'. route('club.clubmember.editmember',$row->id).'" class="btn btn-sm btn-outline-secondary" title="Edit">
    <i class="bi bi-pencil"></i>
</a>

<button type="button" class="btn btn-sm btn-outline-danger" onclick="deletemember(' . $row->id . ')" title="Delete">
    <i class="bi bi-trash"></i>
</button>
                    </div>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    return view('club.clubmember.clubmemberview', compact('club'));
}
public function addmember($id)
    {
        $club = Club::findOrFail($id);
        $clubmember = new ClubMember();
        $countries = Country::orderBy('name')->get();
        $address= new Address();
        // $state=State::all();
        $message=" ";
        return view('club.clubmember.form', compact('club','clubmember','message','countries','address'));
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

        $memberData = [
                'name'      => $clubmember->name,
                'email'     => $clubmember->email,
                'contact'   => $clubmember->contact,
                'address'   => $address->address1,
                'city'      => $address->city,
                'state'     => $address->state_id,
                'zip_code'  => $address->zip_code,
            ];



        Mail::to($memberData['email'])->send(new ClubMemberMail($memberData, 'update'));
        // return view('admin.clubmember.viewmember', compact('club'));
        return redirect()
                ->route('club.member.list', $club->id)
                ->with('success', 'Updated successfully');
    }
    public function storemember(Request $request, $id)
{
    $request->validate([
       'name' => 'required|regex:/^[A-Za-z\\s\\.\\-]+$/',
        'address' => 'required|string',
        'contact' => 'required|string|max:10',
        'email'   => 'required|email|unique:club_members,email',
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
        // 'club_id'         => $id,
        'club_member_id'  => $clubmember->id,
        'status'    => 1,
    ]);

    //Update address_id
    $clubmember->update([
        'address_id' => $address->id,
    ]);
    //to send mail to club member
     $memberData = [
        'name'       => $clubmember->name,
        'email'      => $clubmember->email,
        'contact'    => $clubmember->contact,
        'image'      => $clubmember->image,
        'club_id'    => $clubmember->club_id,

        'address'    => $address->address1,
        'city'       => $address->city,
        'state'      => $address->state_id,
        'country'    => $address->country_id,
        'zip_code'   => $address->zip_code,
    ];

    Mail::to($memberData['email'])->send(new ClubMemberMail($memberData, 'create'));

    return redirect()
        ->route('club.member.list', $id)
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
        'club.clubmember.form',
        compact('clubmember', 'club', 'address', 'countries', 'states')
    );
}
public function deletemember($id)
    {
        $clubmember = ClubMember::findOrFail($id);
        $clubmember->delete(); 
        return redirect()->back()->with('success', 'club member as deleted successfully');
    }
    public function profile($id)
    {
        $club=Club::findorfail($id);
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('club.profile',compact('club','countries','states'));
    }
    public function editprofile(Request $request, $id)
{
    $club = Club::findOrFail($id);

    $request->validate([
        'name'    => 'required|regex:/^[A-Za-z\s\.\-]+$/',
        'address' => 'required|string',
        'contact' => 'required|regex:/^\+?[1-9]\d{6,14}$/',
        'email'   => ['required','email'],
        'country' => 'required|integer|exists:countries,id',
        'state'   => 'required|integer|exists:states,id',
        'city'    => 'required|string|max:100',
        'zip_code'=> 'required|regex:/^[A-Za-z0-9\-\s]{3,10}$/',
        'status'  => 'nullable|boolean',
        'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imagePath = $club->image;

    if ($request->hasFile('image')) {
        if ($club->image && \Storage::disk('public')->exists($club->image)) {
            \Storage::disk('public')->delete($club->image);
        }

        $imagePath = $request->file('image')->store('club_profile_images', 'public');
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
        ->route('club.club.profile', $club->id)
        ->with('success', 'Profile updated successfully!');
}
    public function show(Request $request, $id)
    {
        $club = Club::findOrFail($id);

       $orders = Order::with(['items.product', 'items.variant'])
    ->where('club_id', $id)
    ->orderByRaw("CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END")
    ->orderByDesc('id')
    ->get();

        return view('club.clubmember.vieworder', compact('club', 'orders'));
    }
    public function toMicro(Request $request, Club $club)
    {
        if ($request->ajax()) {

            $microsites = Microsite::query()
                ->where('club_id', $club->id) // use $club->id here
                ->select([
                    'microsite.id',
                    'microsite.name',
                    'microsite.start_date',
                    'microsite.end_date',
                    'microsite.image',
                    'microsite.status',
                    'microsite.created_at'
                ]);

            return datatables()
                ->eloquent($microsites)
                ->editColumn('start_date', fn($m) => $m->start_date->format('d M Y'))
                ->editColumn('end_date', fn($m) => $m->end_date->format('d M Y'))
                ->addColumn('microsite_status', function ($microsite) {

                    $today = Carbon::today();

                    if ($today->lt($microsite->start_date)) {
                        return '<span class="badge bg-warning">Upcoming</span>';
                    }

                    if ($today->between($microsite->start_date, $microsite->end_date)) {
                        return '<span class="badge bg-success">Active</span>';
                    }

                    return '<span class="badge bg-danger">Expired</span>';
                })
                ->addColumn('status', function ($microsite) {

                    $checked = $microsite->status ? 'checked' : '';

                    return '
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-status"
                                type="checkbox"
                                data-id="'.$microsite->id.'"
                                '.$checked.'>
                        </div>
                    ';
                })
                ->addColumn('action', function ($microsite) {
 
                    $actions = '<div class="d-flex gap-1">';
                    $actions .= '<button class="btn btn-sm btn-clean btn-outline-warning showMicrositeProducts" data-id="'.$microsite->id.'" title="Show">
                        <i class="fas fa-box-open" ></i></button>';
                    $actions .= '<button class="btn btn-sm btn-clean btn-outline-warning showMicrosite" data-id="'.$microsite->id.'" title="Show">
                        <i class="fas fa-eye" ></i></button>';
                    $actions .= '<a href="' . route('club.editmicrosite', $microsite->id) . '" class="btn btn-sm btn-outline-secondary" 
                    title="Edit"><i class="fas fa-pencil-alt"></i></a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-outline-danger delete-microsite" data-id="' . $microsite->id . 
                        '"data-bs-toggle="modal" data-bs-target="#delete-modal" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['microsite_status','status','action'])
                ->make(true);
        }
        return view('club.microsite_management.show_microsite', compact('club'));
    }
    public function showMicro(Microsite $microsite)
    {
        $microsite->load('club');

        $today = Carbon::today();

        if ($today->lt($microsite->start_date)) {
            $microsite_status = 'Upcoming';
        } elseif ($today->between($microsite->start_date, $microsite->end_date)) {
            $microsite_status = 'Active';
        } else {
            $microsite_status = 'Expired';
        }

        return response()->json([
            'name' => $microsite->name,
            'description' => $microsite->description,
            'start_date' => Carbon::parse($microsite->start_date)->format('d M Y'),
            'end_date' => Carbon::parse($microsite->end_date)->format('d M Y'),
            'status' => $microsite->status ? 'Active' : 'Inactive',
            'microsite_status' => $microsite_status,
            'club' => $microsite->club->name ?? 'N/A',
            'image' => $microsite->image 
                ? asset('storage/' . $microsite->image) 
                : null,
            'password' => $microsite->password ?? '—',
        ]);
    }
    public function create($clubId)
    {
        $club = Club::findOrFail($clubId);
        $microsite = new Microsite();
        return view('club.microsite_management.add_microsite', compact('club', 'microsite'));
    }
    public function update(Request $request, Microsite $microsite)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($microsite->image) && Storage::disk('public')->exists($microsite->image)) {
                Storage::disk('public')->delete($microsite->image);
            }
            $imagePath = $request->file('image')->store('microsite_banner_images', 'public');

        } else {
        $imagePath = $microsite->image;
        }
        $microsite->update([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date'    => Carbon::parse($request->end_date)->format('Y-m-d'),
            'image'       => $imagePath,
            'status'      => $request->status ?? 0, // checkbox fallback
        ]);
        return redirect()
            ->route('club.show_microsites', $microsite->club_id)
            ->with('success', 'Microsite updated successfully');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'description' => 'required|string|regex:/^[A-Za-z\s]+$/', 
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'club_id'     => 'required|exists:clubs,id',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'Microsite name is required',
            'name.regex' => 'Only letters and spaces allowed',
            'description.required' => 'Microsite description is required',
            'description.regex' => 'Only letters and spaces allowed',
            'start_date.required' => 'Microsite start date is required',
            'end_date.required' => 'Microsite end date is required',
            'club_id.required'     => 'Club ID is required',
        ]);

        $imagePath = $request->file('image')
                         ->store('microsite_banner_images', 'public');

        $password = Str::random(6);
    $slug = Str::slug($validated['name']);

        $microsite = Microsite::create([
            'name'   => $validated['name'],
            'slug'   => $slug,
            'description'   => $validated['description'],
            'start_date'   => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'club_id'   => $validated['club_id'],
            'image'       => $imagePath,
            'password'    => $password,
            // 'password'    => Hash::make($password),
            'status' => $validated['status'] ?? 0,
        ]);
        //Generate URL
        $accessUrl = route('microsite.login', ['slug' => $microsite->slug]);

        // $members = ClubMember::where('club_id', $validated['club_id'])->get();

        $emails = ClubMember::where('club_id', $validated['club_id'])
            ->whereNotNull('email')
            ->distinct()
            ->pluck('email');

            // dd($emails);

        foreach ($emails as $email)
        {
            $isSaleStarted = now()->greaterThanOrEqualTo($microsite->start_date);

            Mail::to($email)->send(
                new MicrositeMail(
                    $email,
                    $accessUrl,
                    $password,
                    'create', // or 'update' / 'url'
                    $microsite->name,
                    $isSaleStarted,
                    $microsite->start_date
                )
            );
        }

        return redirect()
            ->route('club.show_microsites', $validated['club_id'])
            ->with('success', 'Microsite created! Access URL: ' . $accessUrl);
            // ->with('success', 'Microsite registered successfully! ');
            // ->with('success', 'Microsite registered successfully! Password: ' . $password);
    }
    public function edit($id)
    {
        $microsite = Microsite::findOrFail($id);
        $club = Club::findOrFail($microsite->club_id);
        return view('club.microsite_management.add_microsite',compact('microsite', 'club'));
    }
    public function destroyMicro(Request $request)
    {
        Microsite::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }
    public function products($micrositeId)
    {
        $microsite = Microsite::findOrFail($micrositeId);
        $club = Club::findOrFail($microsite->club_id);

        $micrositeProducts = DB::table('microsite_products')
    ->join('products', 'microsite_products.product_id', '=', 'products.id')
    ->leftJoin('varients', 'varients.id', '=', 'microsite_products.varient_id') // ✅ KEY FIX
    ->where('microsite_products.microsite_id', $micrositeId)
    ->select(
        'products.id',
        'products.name',
        'products.description',
        'products.category_id',
        'varients.size',
        'varients.color',
        'varients.image as variant_image',
        'varients.stock',
        'microsite_products.id as microsite_product_id'
    )
    ->get();

        $products = DB::table('products')
        ->leftJoin('varients', 'varients.product_id', '=', 'products.id')
        ->select(
            'products.*',
            'varients.id as variant_id',
            'varients.image as variant_image',
            'varients.size',
            'varients.color',
            'varients.stock',

        )
        ->get();
    $categories = Category::where('status', 1)->get();

        return view(
            'club.microsite_management.list_products',
            compact('microsite','club','micrositeProducts','products','categories')
        );
    }
    //add products into microsite
    public function addProductToMicrosite(Request $request)
    {
        $exists = DB::table('microsite_products')
            ->where('microsite_id', $request->microsite_id)
            ->where('product_id', $request->product_id)
            ->where('varient_id', $request->varient_id) // ✅ IMPORTANT
            ->exists();

        if (!$exists) {
            DB::table('microsite_products')->insert([
                'microsite_id' => $request->microsite_id,
                'product_id'   => $request->product_id,
                'club_id'      => $request->club_id,
                'varient_id'   => $request->varient_id,
                'status'       => 1
            ]);
        }
        return back()->with('success', 'Product added to microsite');
    }
    //remove products from microsite
    public function removeProductFromMicrosite(Request $request)
    {
        DB::table('microsite_products')
            ->where('id', $request->microsite_product_id)
            ->delete();

        return back()->with('success', 'Product removed successfully');
    }
}