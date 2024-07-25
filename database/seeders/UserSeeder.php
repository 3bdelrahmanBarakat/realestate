<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '01012345678',
            "gender" => 'male',
            'password' => Hash::make('Admin123@'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin2',
            'email' => 'admin1@admin.com',
            'phone' => '01012345679',
            "gender" => 'male',
            'password' => Hash::make('Admin123@'),
            'role' => 'admin',
        ]);

        User::factory()->count(50)->create();
    }
}
