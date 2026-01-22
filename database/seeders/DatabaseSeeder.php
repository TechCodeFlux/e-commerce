<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Club;
use App\Models\Clubmember;
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
            [   'name' => 'Admin User',
                'password' => 'password',
            ]
        );
        Club::create([
            'name' => 'Green Valley Golf Club',
            'address' => '123 Golf Course Road',
            'contact' => '9876543210',
            'email' => 'club@xample.com',
            'country_id' => 1,
            'state_id' => 1,
            'city' => 'Bangalore',
            'zip_code' => '560001',
            'status' => '0',
            'password' => Hash::make('password123'),
        ]);
        Clubmember::updateOrCreate(
            ['email' => 'abc@example.com'], // condition
            [   'name' => 'clubmember User',
                'password' => 'password1',
            ]
        );
    }
}
