<?php

namespace App\Models;
use App\Models\ClubMember;      

use Illuminate\Database\Eloquent\Model;
// use App\Http\Controllers\ClubController;



class ClubMember extends Model
{
HEAD
    use SoftDeletes;
=======
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

>>>>>>> arjun-dev
}


