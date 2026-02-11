<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Varient extends Model
{
    use SoftDeletes;
    protected $fillable =['size','color','stock','product_id','status'];
}
