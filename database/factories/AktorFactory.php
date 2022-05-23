<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aktor>
 */
class AktorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'film_id' => $this->faker->numberBetween(1,\App\Models\Film::count()),
            'nama' => $this->faker->name(),
            'gambar' => $this->faker->sentence().'jpg',
        ];
    }
}
