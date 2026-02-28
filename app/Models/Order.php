<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;
        protected $fillable = [
            'quantity',
            'product_id',
            'club_member_id',
            'club_id',
            'varient_id',
            'order_status_id',
            'microsite_id',
        ];
 
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
        return $this->hasOne(Address::class,);
    }

    public function microsite()
    {
        return $this->belongsTo(Microsite::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
     public function varient()
    {
        return $this->belongsTo(Varient::class, 'varient_id');
    }
}
