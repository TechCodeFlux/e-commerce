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
            ['email' => 'admin@example.com'], // Admin
            [   'name' => 'Admin User',
                'password' => 'password',
            ]
        );
        
        Clubmember::updateOrCreate(
            ['email' => 'clubmember@example.com'], // clubmember
            [   'name' => 'Clubmember'
            ]
        );

       
        

    }
}
