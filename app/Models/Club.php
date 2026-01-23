<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'address',
        'country_id',
        'state_id',
        'city',
        'contact',
        'zip_code',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
