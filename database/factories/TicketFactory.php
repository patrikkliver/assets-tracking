<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => '2',
            'number' => time().rand(10,99),
            'start_date' => fake()->date,
            'end_date' => fake()->date,
            'request_desc' => 'description',
            'status' => '0',
            'action_date' => fake()->date,
            'action_desc' => 'description',
        ];
    }
}
