<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Microsite;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Category;
// use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Hash;
use App\Mail\MicrositeMail;
use Illuminate\Support\Facades\Mail;

class MicrositeController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request, Club $club)
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
                    $actions .= '<a href="' . route('admin.editmicrosite', $microsite->id) . '" class="btn btn-sm btn-outline-secondary" 
                    title="Edit"><i class="fas fa-pencil-alt"></i></a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-outline-danger delete-microsite" data-id="' . $microsite->id . 
                        '"data-bs-toggle="modal" data-bs-target="#delete-modal" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['microsite_status','status','action'])
                ->make(true);
        }
        return view('admin.microsite_management.show_microsite', compact('club'));
    }

    public function changeStatus(Request $request)
    {
        $microsite = Microsite::find($request->id);
        if ($microsite) {
            $microsite->status = $request->status;
            $microsite->save();

            return response()->json(['success' => 'Status changed successfully.']);
        }
        return response()->json(['error' => 'Microsite not found.'], 404);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($clubId)
    {
        $club = Club::findOrFail($clubId);
        $microsite = new Microsite();
        return view('admin.microsite_management.add_microsite', compact('club', 'microsite'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            ->route('admin.show_microsites', $validated['club_id'])
            ->with('success', 'Microsite created! Access URL: ' . $accessUrl);
            // ->with('success', 'Microsite registered successfully! ');
            // ->with('success', 'Microsite registered successfully! Password: ' . $password);
    }

    /**
     * Display the specified resource.
     */
    public function show(Microsite $microsite)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $microsite = Microsite::findOrFail($id);
        $club = Club::findOrFail($microsite->club_id);
        return view('admin.microsite_management.add_microsite',compact('microsite', 'club'));
    }

    /**
     * Update the specified resource in storage.
     */
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
            ->route('admin.show_microsites', $microsite->club_id)
            ->with('success', 'Microsite updated successfully');
    }


    //Public club member login for microsite access
    public function showLogin($slug)
    {

    $microsite = Microsite::where('slug',$slug)->firstOrFail();

    return view('clubmember.auth.login',compact('microsite'));

    }
    public function login(Request $request, $slug)
    {
        $microsite = Microsite::where('slug', $slug)->firstOrFail();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $member = ClubMember::where('email', $request->email)
                    ->where('club_id', $microsite->club_id)
                    ->first();

        if (!$member) {
            return back()->withErrors(['email' => 'You are not a member of this club']);
        }

        if ($request->password !== $microsite->password) {
            return back()->withErrors(['password' => 'Invalid microsite password']);
        }

        $today = now()->toDateString();
        if ($today < $microsite->start_date) {
            return back()->withErrors(['email' => 'Microsite sale has not started yet']);
        }
        if ($today > $microsite->end_date) {
            return back()->withErrors(['email' => 'Microsite sale has expired']);
        }

        // Store session
        session([
            'clubmember_id' => $member->id,
            'microsite_id' => $microsite->id,
            'club_id' => $microsite->club_id,
        ]);
        // Fetch club object
        $club = $microsite->club; // make sure Microsite has belongsTo(Club::class)

        // Fetch microsite products
    $micrositeProducts = DB::table('microsite_products')
        ->join('products', 'products.id', '=', 'microsite_products.product_id')
        // ->join('varients', 'varients.product_id', '=', 'products.id')
        ->where('microsite_products.microsite_id', $microsite->id)
        ->select(
            'products.id',
            'products.name',
            'products.description',
            // 'varients.image as variant_image',
            'products.category_id'
        )
        ->get();

    // Fetch categories used by these products
    $categories = Category::whereIn(
        'id',
        $micrositeProducts->pluck('category_id')->unique()
    )->get();

    return view('clubmember.microsite.home', compact(
        'microsite',
        'club',
        'micrositeProducts',
        'categories'
    ));
    }

    public function variants($id)
{
    $variants = DB::table('varients')
        ->where('product_id',$id)
        ->get();

    return response()->json($variants);
}


    //add products into microsite blade page
    public function products($micrositeId)
{
    $microsite = Microsite::findOrFail($micrositeId);
    $club = Club::findOrFail($microsite->club_id);

    $micrositeProducts = DB::table('microsite_products')
    ->join('products', 'microsite_products.product_id', '=', 'products.id')
    ->leftJoin('varients', function ($join) {
        $join->on('varients.product_id', '=', 'products.id')
             ->where('varients.status', 1);
    })
    ->where('microsite_products.microsite_id', $micrositeId)
    ->select(
        'products.id',
        'products.name',
        'products.description',
        'products.category_id', // IMPORTANT
        DB::raw('(select image from varients where varients.product_id = products.id limit 1) as variant_image'),
        'microsite_products.id as microsite_product_id'
    )
    ->get();

    $products = DB::table('products')
    ->leftJoin('varients', function($join){
        $join->on('varients.product_id','=','products.id')
             ->whereRaw('varients.id = (select id from varients where varients.product_id = products.id limit 1)');
    })
    ->select(
        'products.*',
        'varients.image as variant_image'
    )
    ->get();
    $categories = Category::all();

    return view(
        'admin.microsite_management.list_products',
        compact('microsite','club','micrositeProducts','products','categories')
    );
}
//add products into microsite
public function addProductToMicrosite(Request $request)
{
    $exists = DB::table('microsite_products')
    ->where('microsite_id',$request->microsite_id)
    ->where('product_id',$request->product_id)
    ->exists();

if(!$exists){
    DB::table('microsite_products')->insert([
        'microsite_id'=>$request->microsite_id,
        'product_id'=>$request->product_id,
        'club_id'=>$request->club_id,
        'varient_id'=>0,
        'status'=>1
    ]);
}

    return back()->with('success','Product added to microsite');
}
//remove products from microsite
public function removeProductFromMicrosite(Request $request)
{
    DB::table('microsite_products')
        ->where('id', $request->microsite_product_id)
        ->delete();

    return back()->with('success', 'Product removed successfully');
}

    //
    public function logout(Request $request, $slug)
    {
        auth('clubmember')->logout();

        return redirect()->route('microsite.login', $slug);
    }
    //End Public club member login for microsite access
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Microsite::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }
}
