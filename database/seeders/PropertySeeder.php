<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyFeature;
use App\Models\RentalDetail;
use App\Models\CommercialLandDetail;
use App\Models\OtherPropertyDetail;
use App\Models\OtherPropertyFeature;
use App\Models\Owner;
use App\Models\PropertyAmenity;
use App\Models\User;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $adminID = User::where('role', 'admin')->first();
        $owners = Owner::all();

        for ($i = 0; $i < 50; $i++) {
            $randomOwner = $faker->randomElement($owners);
            $property = Property::create([
                'marketer_name' => $faker->name,
                'owner_id' => $randomOwner->id,
                'admin_id' => $adminID->id,
                'distinctive_address' => $faker->address,
                'type' => $faker->randomElement(['for sale', 'for rent']),
                'unit_type' => $faker->randomElement(['Apartment', 'Villa', 'Studio', 'Challet']),
                'purpose' => $faker->randomElement(['residential', 'commercial']),
                'description' => $faker->paragraph,
                'deposit' => $faker->numberBetween(5000, 100000),
                'price' => $faker->numberBetween(5000, 100000),
                'area' => $faker->numberBetween(50, 1000),
                'floor' => $faker->numberBetween(1, 10),
                'previously_occupied' => $faker->boolean,
                'property_age' => $faker->numberBetween(1, 20),
                'property_facing' => $faker->randomElement(['north', 'south', 'east', 'west']),
                'status' => $faker->randomElement(['Pending', 'Sold', 'Rented', 'Hidden']),
                'city' => $faker->city,
                'district' => $faker->word,
                'location_link' => $faker->url,
                'owner_name' => $randomOwner->name,
                'owner_phone' => $randomOwner->phone,
                'guard_name' => $faker->name,
                'guard_phone' => $faker->phoneNumber,
                'other_attachment' => "pexels-pixabay-259588 1 (1)-1720508841.png",
                'available_date' => $faker->date(),
            ]);

            // Add images
            for ($j = 0; $j < 5; $j++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => "504233-landscape-Firewatch-tower-colorful-minimalism-1720362507.jpg",
                ]);
            }

            // Add features
            PropertyFeature::create([
                'property_id' => $property->id,
                'has_private_entrance' => $faker->boolean,
                'rooms_num' => $faker->numberBetween(1, 5),
                'bedrooms_num' => $faker->numberBetween(1, 5),
                'living_rooms_num' => $faker->numberBetween(1, 3),
                'toilets_num' => $faker->numberBetween(1, 3),
                'has_board' => $faker->boolean,
                'has_floor_seating' => $faker->boolean,
                'classification' => $faker->randomElement(['for family', 'for individuals']),
                'has_mashab' => $faker->boolean,
                'has_roof' => $faker->boolean,
            ]);

            // Add other features
            for ($k = 0; $k < 5; $k++) {
                OtherPropertyFeature::create([
                    'property_id' => $property->id,
                    'feature' => $faker->word,
                ]);
            }

            // Add other details
            for ($k = 0; $k < 3; $k++) {
                OtherPropertyDetail::create([
                    'property_id' => $property->id,
                    'detail' => $faker->word,
                ]);
            }
            // Add property amenities
            for ($k = 0; $k < 3; $k++) {
                PropertyAmenity::create([
                    'property_id' => $property->id,
                    'amenity' => $faker->word,
                ]);
            }

            // Add rental details if the property is for rent
            if ($property->type === 'for rent') {
                RentalDetail::create([
                    'property_id' => $property->id,
                    'rental_type' => $faker->randomElement(['monthly', 'yearly']),
                ]);
            }

            // Add commercial land details if the property is a commercial land
            // if ($property->purpose === 'commercial') {
            //     CommercialLandDetail::create([
            //         'property_id' => $property->id,
            //         'land_width' => $faker->numberBetween(10, 1000),
            //         'land_length' => $faker->numberBetween(10, 1000),
            //         'masterplan_number' => $faker->numberBetween(10, 1000),
            //         'land_number' => $faker->numberBetween(10, 1000),
            //         'price_per_meter' => $faker->numberBetween(10, 1000),
            //     ]);
            // }
        }
    }
}
