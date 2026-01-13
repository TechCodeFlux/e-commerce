<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}
