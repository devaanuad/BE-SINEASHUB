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
        \App\Models\Film::factory(10)->create();
        \App\Models\Creator::factory(18)->create();
        \App\Models\Aktor::factory(60)->create();
        \App\Models\Transaction::factory(5)->create();
        \App\Models\DetailTransaction::factory(5)->create();
        \App\Models\FilmDetails::factory(10)->create();
        \App\Models\LikedFilm::factory(50)->create();
        $genre = ['comedy','action','drama','romance','gore','sci-fi','fiction','mecha'];
        foreach($genre as $g){
            \App\Models\Genre::create([
                'name' => $g
            ]);
        }
        \App\Models\FilmGenre::factory(50)->create();
    }
}
