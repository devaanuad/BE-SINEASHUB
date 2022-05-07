<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creator>
 */
class CreatorFactory extends Factory
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
            'sutradara' => $this->faker->name(),
            'penulis' => $this->faker->name(),
            'perusahaan_produksi' => $this->faker->company()
        ];
    }
}
