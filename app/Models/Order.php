<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    public function items()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function clubMember()
    {
        return $this->belongsTo(ClubMember::class, 'club_member_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function microsite()
    {
        return $this->belongsTo(Microsite::class);
    }

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
     public function varient()
    {
        return $this->belongsTo(Varient::class, 'varient_id');
    }
    public function country()
    {
        return $this->belongsto(varients::class);
    }
    public function member()
    {
            return $this->belongsTo(ClubMember::class, 'club_member_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

}
