<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrderStatus;
class StatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_statuses')->insert([
    [
        'status' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Confirmed',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Processing',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Shipped',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Packed',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Out for delivery',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Delivered',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'status' => 'Cancelled',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
