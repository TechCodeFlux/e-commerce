<?php

namespace App\Models;   

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClubMember extends Authenticatable
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'club_id',
        'address_id',
        'contact',
        'email',
        'status',
   ];

   public function address() {
    return $this->belongsTo(Address::class, 'address_id');
}

}

