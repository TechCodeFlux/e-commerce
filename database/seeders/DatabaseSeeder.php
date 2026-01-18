<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Club;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //$this->call(UserSeeder::class);

        
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // condition
            [   'name' => 'Admin User',
                'password' => 'password',
            ]
        );

        Club::updateOrCreate(      //clubs table seeder
            ['name'=>'arun',
            'email'=>'arun@test.com',
            'contact'=>'9876543210',
            'address'=>'test address',
            'country_id'=>1,
            'state_id'=>'1',
            'city'=>'test city',
            'zip_code'=>'123456',
            'password'=>Hash::make('password')
            ]
        );
    }
}
