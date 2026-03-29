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
        // 'club_id',
        'club_member_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function clubMember()
    {
        return $this->belongsTo(ClubMember::class);
    }
    public function getFullAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->address1,
            $this->address2,
            $this->city,
            optional($this->state)->name,
            optional($this->country)->name,
            $this->zip_code,
        ]));
    }
}
