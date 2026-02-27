<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubMember extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'club_id',
        'address_id',
        'contact',
        'password',
        'email',
        'status',
        'image',
    ];


    // ================= RELATIONSHIPS =================

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}