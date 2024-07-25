<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AppointmentSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Faker::create();
        $users = DB::table('users')->where('role', 'user')->pluck('id')->all();
        $employeeId = DB::table('users')->where('role', 'admin')->pluck('id')->first();

        $properties = DB::table('properties')->pluck('id')->all();

        $appointmentsToCreate = 3000;
        $baseDateTime = Carbon::now();

        for ($i = 0; $i < $appointmentsToCreate; $i++) {
                $userId = $users[array_rand($users)];


            $propertyId = $properties[array_rand($properties)];
            $uniqueDateTime = $baseDateTime->addMinutes($i * 30);

            DB::table('appointments')->insert([
                'title' => $faker->word(),
                'employee_id' => $employeeId,
                'user_id' => $userId,
                'property_id' => $propertyId,
                'start_date_time' => $uniqueDateTime->format('Y-m-d H:i'),
                'end_date_time' => $uniqueDateTime->addHours(24)->format('Y-m-d H:i'),
                'status' => 'reserved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
