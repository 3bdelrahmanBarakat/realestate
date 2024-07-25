<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PropertyListingSeeder extends Seeder
{
   
    public function run(): void
    {

        $faker = Faker::create();
        $propertyIds = Property::all()->pluck('id')->toArray();
        $statuses = ['sold', 'rented',];
        $revenues = [1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000];

        foreach ($propertyIds as $propertyId) {
            DB::table('property_listings')->insert([
                'property_id' => $propertyId,
                'admin_id' => 2,
                'revenue' => $faker->randomElement($revenues),
                'status' => $faker->randomElement($statuses),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
