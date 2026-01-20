<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use app\Models\Club;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Club extends Authenticatable 
{
    use SoftDeletes;

    protected $fillable =  ['name','email', 'address','country_id','state_id','contact','city','status','zip_code','password'];
}
