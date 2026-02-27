<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
        'club_id',
        'category_id',
    ];
    public function varients()
    {
        return $this->hasMany(Varient::class);
    }

}
