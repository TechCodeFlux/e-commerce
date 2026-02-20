<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;
     protected $fillable =  ['name','status','parent_id'];

        public function product()
{
      return $this->hasMany(Product::class, 'category_id', 'id');
}

}
