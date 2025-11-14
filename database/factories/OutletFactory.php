<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'link_gojek' => 'https://7am.me',
            'link_grab' => 'https://7am.me',
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'address' => fake()->address(),
            'description' => fake()->paragraphs(asText: true)
        ];
    }
}
