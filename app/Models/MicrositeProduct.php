<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MicrositeProduct extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'microsite_id',
        'product_id',
        'varient_id',
        'club_id',
        'status',
    ];
}
