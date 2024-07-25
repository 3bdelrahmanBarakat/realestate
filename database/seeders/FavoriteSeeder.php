<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{

    public function run(): void
    {
        $properties = Property::where('status', 'Pending')->get();
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $favoriteProperties = $properties->random(3);
            foreach ($favoriteProperties as $property) {
                $user->favorites()->create([
                    'property_id' => $property->id
                ]);
            }
        }
    }
}
