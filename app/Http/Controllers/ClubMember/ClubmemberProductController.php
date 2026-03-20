<?php

namespace App\Http\Controllers\ClubMember;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use Illuminate\Http\Request;

class ClubmemberProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $microsite_id=1;  // must change or pass id to funtion
    if ($request->ajax()) {

        $products = DB::table('products')
            ->leftJoin('varients', 'varients.product_id', '=', 'products.id')
            ->where('varients.stock' ,'>', 0)
            ->whereNull('varients.deleted_at')
            ->where('microsite_id',$microsite_id)
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.description',
                'varients.size',
                'varients.id as varient_id',
                'varients.color',
                'varients.stock'
            );

        return DataTables::of($products)
            ->addColumn('action', function ($row) {
                return  '<a href="'.route('clubmember.addcart',$row->varient_id).'"class="btn btn-sm btn-clean btn-icon" title="Add to Cart">
                                <i class="fas fa-shopping-cart fa-lg text-center" style="color: #28a745;"></i>
                            </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('clubmember.product.viewproduct');
}
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
