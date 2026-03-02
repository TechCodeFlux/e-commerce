<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    public function product()
{
    return $this->belongsTo(\App\Models\Product::class);
}

public function member()
{
    return $this->belongsTo(\App\Models\ClubMember::class, 'club_member_id');
}

public function status()
{
    return $this->belongsTo(\App\Models\OrderStatus::class, 'order_status_id');
}

public function club()
{
    return $this->belongsTo(\App\Models\Club::class);
}

}
