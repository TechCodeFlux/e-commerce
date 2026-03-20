<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Varient;
use App\Models\Product; //for softdelete use this import this

class Cart extends Model
{
    protected $fillable = [
        'name',
        'varient_id',
        'image',
        'description',
        'quantity',
        'price',
        'clubmember_id',
        'microsite_id',
        'product_id',
        
    ];
    use SoftDeletes;    
    
    //for softdelete use this

    public function varient()
    {
        return $this->belongsTo(Varient::class, 'vrient_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
