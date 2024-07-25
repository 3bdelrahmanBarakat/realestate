<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PropertyActionSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Faker::create();
        $propertyIds = Property::all()->pluck('id')->toArray();
        $userIds = User::whereNotIn('id', [1, 2])->pluck('id')->toArray();
        $adminIds = [1, 2]; // Admin IDs

        foreach ($propertyIds as $propertyId) {
            DB::table('property_actions')->insert([
                'property_id' => $propertyId,
                'user_id' => $faker->randomElement($userIds),
                'admin_id' => $faker->randomElement($adminIds),
                'action' => $faker->randomElement(['viewed', 'called', 'sent message', 'whatsapp']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
