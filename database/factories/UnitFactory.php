<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial_number' => \illuminate\Support\Str::random(15),
            'purchase_date' => fake()->date,
            'condition' => 'Good',
            'is_available' => 1,
            'location' => fake()->address,
        ];
    }
}
