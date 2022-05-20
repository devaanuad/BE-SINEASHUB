<?php

namespace App\Observers;

use App\Models\LikedFilm;

class LikedFilmObserver
{
    /**
     * Handle the LikedFilm "created" event.
     *
     * @param  \App\Models\LikedFilm  $likedFilm
     * @return void
     */
    public function created(LikedFilm $likedFilm)
    {
        cache()->forget('liked-film');
    }

    /**
     * Handle the LikedFilm "deleted" event.
     *
     * @param  \App\Models\LikedFilm  $likedFilm
     * @return void
     */
    public function deleted(LikedFilm $likedFilm)
    {
        cache()->forget('liked-film');
    }

    /**
     * Handle the LikedFilm "force deleted" event.
     *
     * @param  \App\Models\LikedFilm  $likedFilm
     * @return void
     */
    public function forceDeleted(LikedFilm $likedFilm)
    {
        cache()->forget('liked-film');
    }
}
