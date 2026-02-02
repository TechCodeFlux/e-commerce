<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
       protected $fillable =  ['name','stock', 'description','image','status','category_id','option_id'];
}
