<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat roles jika belum ada
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Buat atau cari pengguna superadmin
        $superadminEmail = 'superadmin@gmail.com';
        $superadmin = User::where('email', $superadminEmail)->first();

        if (!$superadmin) {
            $superadmin = User::create([
                'name' => 'superadmin', // Pastikan field 'name' disertakan
                'email' => $superadminEmail,
                'password' => bcrypt('superadmin123'), // Gantilah dengan password yang aman
                'nomor_hp' => '1234567890', // Pastikan field 'nomor_hp' ada di fillable
            ]);
        }

        // Assign role ke superadmin
        $superadmin->assignRole('superadmin');

        // Anda dapat menambahkan pengguna lain dan mengassign roles sesuai kebutuhan
    }
}
