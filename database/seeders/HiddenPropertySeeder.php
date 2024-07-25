<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HiddenPropertySeeder extends Seeder
{

    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $properties = Property::where('status', 'Hidden')->get();
        foreach ($properties as $property) {
            $property->hiddenProperties()->create([
                'company_name' => $faker->company,
                'company_phone' => $faker->phoneNumber
            ]);
        }
    }
}
