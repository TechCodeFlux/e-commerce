<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //for softdelete use this import this

class Cart extends Model
{
    protected $fillable = [
        'name',
        'stock',
        'image',
        'description',
        'quantity',
        'clubmember_id',
        'microsite_id',
        'product_id',
        'club_id',
    ];
    use SoftDeletes;           //for softdelete use this
}
