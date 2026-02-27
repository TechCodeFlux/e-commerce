<?php

namespace App\Http\Controllers\ClubMember;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $clubid=0;
         if($request->ajax()){
            $product = Product::with('varients')
                ->where('status',1)
                ->where('club_id',$clubid);
            // return DataTables::eloquent($club)
            return datatables()
        ->eloquent($product)


           ->addColumn('size', fn($row) =>
                    $row->varients->where('stock','>',0)->pluck('size')->unique()->implode(', ') ?: '--'
                )

                ->addColumn('color', fn($row) =>
                    $row->varients->where('stock','>',0)->pluck('color')->unique()->implode(', ') ?: '--'
                )
            ->addColumn('stock', function ($row) {

                if ($row->varients->isEmpty()) {
                    return '--';
                }

                return $row->varients->sum('stock');
            })
        
    
        ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="'.asset('storage/'.$row->image).'" class="img-fluid rounded ;object-fit: contain">';
                }
                return '<span class="text-muted">No Image</span>';
            })
        ->addColumn('action', function (Product $product) use ($request) {
                $actions= '<div class="container-xxl d-flex gap-1 ms-lg-5" >
                                <div class="dropdown ms-md-5 d-flex gap-2 mt-2">';
                // Add to cart button
                $actions .= '<a href="'.route('clubmember.addcart',$product->id).'"class="btn btn-sm btn-clean btn-icon" title="Add to Cart">
                                <i class="fas fa-shopping-cart fa-lg text-center" style="color: #28a745;"></i>
                            </a>';

                // Buy now button 
                $actions .= '<a href="'.route('clubmember.order',$product->id). '" class="btn btn-sm me-2" title="Buy Now">
                                <i class="fas fa-credit-card fa-l -center"></i>
                            </a>';

               
                
              

                $actions .= '</div><div>';
                return  $actions;
            })->rawColumns(['image','action','size','colour','stock'])->make(true);
            
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
