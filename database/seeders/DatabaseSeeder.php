<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('superadmin123'), // Set a default password
            'role' => 'superadmin', // Assign the role of superadmin
        ]);

        $this->call(SuperAdminSeeder::class); 
    }
}
