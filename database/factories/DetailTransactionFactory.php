<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailTransaction>
 */
class DetailTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $stat = ['pending','success','cancel'];
        $tranId = range(1,\App\Models\Transaction::count());
        shuffle($tranId);
        return [
            'transaction_id' => array_unique($tranId),
            'film_id' => $this->faker->numberBetween(1,\App\Models\Film::count()),
            'total_harga' => mt_rand(10000,10000000),
            'nama_film' => $this->faker->unique()->name(\App\Models\Film::pluck('judul')),
            'tanggal_beli' => '2022-02-02',
            'tanggal_berakhir' => '2022-02-05',
            'status' => $stat[mt_rand(0,2)]
        ];
    }
}
