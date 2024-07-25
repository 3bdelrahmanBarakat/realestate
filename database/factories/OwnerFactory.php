<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OwnerFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => Str::substr(fake()->unique()->phoneNumber(), 0, 12),
        ];
    }
}
