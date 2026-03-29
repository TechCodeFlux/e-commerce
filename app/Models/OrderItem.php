<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'order_items';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variant()
{
    return $this->belongsTo(Varient::class, 'variant_id');
}
}   