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
                'country_id'     =>  12,
                'state_id'       =>  244,
                'zip_code'       => 234565,
                'clubmember_id'  =>  1,
                'status'         =>  1,
            ]
        ];

        DB::table('addresses')->insert($address);
    }
    }

