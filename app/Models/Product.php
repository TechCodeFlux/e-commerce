<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
       protected $fillable =  ['name', 'description','image','category_id','option_id','status'];


    public function varients()
{
      return $this->hasMany(Varient::class, 'product_id', 'id');
}

    public function categories()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}
}


