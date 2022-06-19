<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\FilmDetails;
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
        $genre = ['comedy', 'action', 'drama', 'romance', 'gore', 'sci-fi', 'fiction', 'mecha'];
        foreach ($genre as $g) {
            \App\Models\Genre::create([
                'name' => $g
            ]);
        }

        // \App\Models\Film::factory(10)->create()->each(function ($film) {
        //     // Seed the relation with one address
        //     $detail = factory(\App\Models\FilmDetails::class)->make();
        //     $film->detail()->save($detail);
        // });

        Film::factory(100)->create()->each(function ($film) {
            FilmDetails::factory(1)->create(['film_id' => $film->id]);
        });

        \App\Models\Aktor::factory(60)->create();
        \App\Models\FilmGenre::factory(50)->create();
        \App\Models\Rating::factory(100)->create();
        \App\Models\Transaction::factory(5)->create();
        \App\Models\LikedFilm::factory(50)->create();
        // \App\Models\FilmDetails::factory(10)->create();
        // \App\Models\DetailTransaction::factory(5)->create();
    }
}
