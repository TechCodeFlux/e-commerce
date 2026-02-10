<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    'address1',
    'address2',
    'country_id',
    'state_id',
    'city',
    'zip_code',
    'status',
    ];
    use SoftDeletes;
    
     public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
