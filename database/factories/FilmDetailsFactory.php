<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FilmDetails>
 */
class FilmDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $filmId = range(1,\App\Models\Film::count());
        shuffle($filmId);
        return [[
            'film_id' => array_unique($filmId),
            'url_film' => $this->faker->url(true),
            'rating' => mt_rand (10, 50) / 10,
            'tahun' => mt_rand(2000,2022),
            'tanggal_terbit' => '2022-01-01',
            'harga' => mt_rand(10000,10000000),
            'kunjungan' => mt_rand(1,10000),
        ]];
    }
}
