<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Authenticatable
{
    use Notifiable, SoftDeletes;
protected $table = 'clubs';

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
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/club_images/' . $this->image) : asset('img/default-club.png');
    }
}
