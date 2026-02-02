<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class order_status extends Seeder
{
    public function run(): void
    {
        DB::table('order_statuses')->delete();

        $orderstatus = [
            ['status' => 1],
            ['status' => 2],
        ];

        DB::table('order_statuses')->insert($orderstatus);
    }
}
