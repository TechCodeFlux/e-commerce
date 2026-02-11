<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_statuses';

    protected $fillable = [
        'status',
    ];

    /**
     * An order status can belong to many orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}