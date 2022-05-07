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
        return [
            'film_id' => $this->faker->numberBetween(1,\App\Models\Film::count()),
            'url_film' => $this->faker->url(),
            'rating' => mt_rand(1,5) * rand(0.1,1),
            'tahun' => mt_rand(2000,2022),
            'tanggal_terbit' => '2022-01-01',
            'harga' => mt_rand(10000,10000000),
            'kunjungan' => mt_rand(1,10000)
        ];
    }
}
