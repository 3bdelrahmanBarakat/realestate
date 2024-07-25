<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(PropertyActionSeeder::class);
        $this->call(PropertyListingSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(HiddenPropertySeeder::class);
        $this->call(FavoriteSeeder::class);
    }
}
