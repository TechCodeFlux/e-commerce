<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Varient extends Model
{
    use SoftDeletes;
           protected $fillable = ['color', 'size', 'stock','product_id'];

}
