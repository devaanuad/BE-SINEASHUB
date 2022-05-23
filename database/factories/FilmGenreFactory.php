<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FilmGenre>
 */
class FilmGenreFactory extends Factory
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
            'genre_id' => $this->faker->numberBetween(1,\App\Models\Genre::count()),
        ];
    }
}
