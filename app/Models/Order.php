<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function clubMember()
    {
        return $this->belongsTo(ClubMember::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'club_member_id', 'club_member_id');
    }

    public function microsite()
    {
        return $this->belongsTo(Microsite::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}
