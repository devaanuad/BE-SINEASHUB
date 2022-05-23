<?php

namespace App\Observers;

use App\Models\Film;

class FilmObserver
{
    /**
     * Handle the Film "created" event.
     *
     * @param  \App\Models\Film  $film
     * @return void
     */
    public function created(Film $film)
    {
        cache()->forget('all-film-data');
        cache()->forget('rekomendasi');
        // cache()->forget("detail-film-".$film->$id);
    }

    /**
     * Handle the Film "deleted" event.
     *
     * @param  \App\Models\Film  $film
     * @return void
     */
    public function deleted(Film $film)
    {
        cache()->forget('all-film-data');
        cache()->forget('rekomendasi');
        cache()->forget("detail-film-".$film->$id);
    }

    /**
     * Handle the Film "force deleted" event.
     *
     * @param  \App\Models\Film  $film
     * @return void
     */
    public function forceDeleted(Film $film)
    {
        cache()->forget('all-film-data');
        cache()->forget('rekomendasi');
        cache()->forget("detail-film-".$film->$id);
    }
}
