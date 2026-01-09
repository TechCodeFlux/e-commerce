<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected  $fillable = ['name','stock','description','option_id','club_micro_id','category_id','club_id','status'];
}
