<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $stat = ['production','on-air','coming-soon'];
        $filmId = range(1,\App\Models\Film::count());
        shuffle($filmId);
        return [
            'judul' => $this->faker->name(),
            'deskripsi' => $this->faker->paragraph(),
            'tumbnail' => $this->faker->sentence(1).'jpg',
            'creator_id' => $this->faker->unique()->numberBetween(1,\App\Models\Creator::count()),
            'url_trailer' => $this->faker->url(),
            'status' => $stat[\mt_rand(0,2)]
        ];
    }
}
