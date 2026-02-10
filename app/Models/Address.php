<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Address extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'address1',
        'address2',
        'city',
        'state_id',
        'country_id',
        'zip_code',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
