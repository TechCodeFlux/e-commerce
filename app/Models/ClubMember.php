<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubMember extends Model
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
public function club() {
    return $this->belongsTo(Club::class, 'club_id');

}
}
