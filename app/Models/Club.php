<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'contact',
        'address',
        'country_id',
        'state_id',
        'city',
        'status',
        'zip_code',
        'password'
    ];

    protected $hidden = ['password'];
}
