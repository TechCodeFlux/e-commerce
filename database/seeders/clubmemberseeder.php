<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class clubmemberseeder extends Seeder
{
    public function run(): void
    {
        DB::table('club_members')->delete();

        $clubmember = [
            [
                'name'       => 'jose',
                'contact'    => 2345678910,
                'email'      => 'jose@123',
                'address_id' => 1,
                'club_id'    => 1,
                'status'     => 1,
            ]
        ];

        DB::table('club_members')->insert($clubmember);
    }
}
