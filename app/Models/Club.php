<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use SoftDeletes;

    protected $fillable =  ['name','contact', 'address','country_id','state_id','city','status','zip_code','password'];
}
