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

        
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // condition
            [ 
                'name' => 'Admin User',
                'password' => 'password',
            ]
        );
        Club::updateOrCreate(
            ['email' => 'club@first.com'], // condition
            [   
                'name' => 'Club',
                'contact' => '1234567890',
                'address' => 'abxd',
                'country_id' => '+1',
                'state_id' => '12',
                'city' => 'new',
                'zip_code' => '12345',
                'status' => '0',
                'password' => Hash::make('password'),
            ]
        );
    }

}
