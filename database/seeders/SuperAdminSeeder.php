<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user dengan role superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@tenshibot.com',
            'password' => Hash::make('superadmin123'), 
            'nomor_hp' => '085861765261', 
            'role' => 'superadmin', 
        ]);
    }
}
