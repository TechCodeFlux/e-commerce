<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use app\Models\Club;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use SoftDeletes;

    protected $fillable = 
            ['name','email','contact','address','country_id','state_id','city','zip_code','password'
            ];
}
