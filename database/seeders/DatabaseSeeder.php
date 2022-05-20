<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(2)->create();
        \App\Models\Creator::factory(18)->create();
        \App\Models\Film::factory(10)->create();
        \App\Models\Aktor::factory(60)->create();
        \App\Models\Transaction::factory(5)->create();
        \App\Models\LikedFilm::factory(50)->create();
        // \App\Models\FilmDetails::factory(10)->create();
        // \App\Models\DetailTransaction::factory(5)->create();
        $genre = ['comedy','action','drama','romance','gore','sci-fi','fiction','mecha'];
        foreach($genre as $g){
            \App\Models\Genre::create([
                'name' => $g
            ]);
        }
        // $filmId = range(1,\App\Models\Film::count());
        // shuffle($filmId);
        // $transId = range(1,\App\Models\Transaction::count());
        // shuffle($transId);
        // $judulFilm = \App\Models\Film::pluck('judul')->toArray();
        // $stat = ['pending','success','cancel'];
        // for($i = 0;$i < \App\Models\Film::count();$i++){
        //     \App\Models\FilmDetails::create([
        //         'film_id' => array_unique($filmId),
        //         'url_film' => '-',
        //         'rating' => mt_rand(10,50) / 10,
        //         'tahun' => mt_rand(2010,2022),
        //         'tanggal_terbit' => '2022-05-10',
        //         'harga' => mt_rand(5000,20000),
        //         'kunjungan' => mt_rand(1,10000)
        //     ]);
        // }
        // for($i = 0;$i < \App\Models\Transaction::count();$i++){
        //     \App\Models\DetailTransaction::create([
        //         'transaction_id' => array_unique($transId),
        //         'film_id' => array_unique($filmId),
        //         'nama_film' => $judulFilm[mt_rand(1,\App\Models\Film::count())],
        //         'tanggal_beli' => '2022-05-13',
        //         'tanggal_terbit' => '2022-05-15',
        //         'total_harga' => mt_rand(5000,20000),
        //         'status' => $stat[mt_rand(0,2)]
        //     ]);
        // }
        \App\Models\FilmGenre::factory(50)->create();
    }
}
