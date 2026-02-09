<?php

namespace App\Models;
use App\Models\ClubMember;      
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\ClubController;



class ClubMember extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'club_id',
        'address_id',

    ];

      public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }


}


