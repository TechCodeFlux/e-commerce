<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class addressseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addresses')->delete();

        $address = [
            [
                'address1'       => 'angamaly p.o,angamaly',
                'city'           => 'ernakulam',
                'state'          => 'kerela',
                'zip-code'       => 234565,
                'club_member_id'  => 1,
                'status'         => 1,
            ]
        ];

        DB::table('addresses')->insert($address);
    }
    }

