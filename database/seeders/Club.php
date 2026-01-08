<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Club extends Seeder
{
    public function run()
    {
        DB::table('clubs')->insert([
            'name'       => 'maths',
            'address'    => '123 math street',
            'contact'    => '1234567890',
            'username'   => 'mathsuser',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
