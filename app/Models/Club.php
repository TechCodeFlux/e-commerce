<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'address',
        'country_id',
        'state_id',
        'contact',
        'city',
        'status',
        'zip_code',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
