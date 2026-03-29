<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class OrderItem extends Model
{
    use SoftDeletes;
       protected $fillable = [
            'quantity',
            'order_id',
            'microsite_id',
            'product_id',
            'status',
            'address_id'
        ];
        
    
}


