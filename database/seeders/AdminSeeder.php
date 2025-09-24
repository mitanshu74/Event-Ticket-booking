<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('Admin@123'),
                'role' => 1, // 1 = Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sub Admin',
                'email' => 'subadmin@gmail.com',
                'password' => bcrypt('Admin@123'),
                'role' => 2, // 2 = Subadmin
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
