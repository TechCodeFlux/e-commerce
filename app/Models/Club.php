<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use SoftDeletes;

    protected $fillable =  ['name','email', 'address','country_id','state_id','contact','city','status','zip_code','password'];
}
