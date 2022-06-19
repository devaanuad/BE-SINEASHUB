<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\FilmDetails;
use App\Models\Genre;
use App\Http\Resources\FilmResource;
use App\Http\Resources\FilmDetailsResource;
// use App\Http\Resources\SearchResource;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            cache()->forget('all-film-data');
            $films = cache()->remember('all-film-data', 60*60*24, function () {
                return FilmResource::collection(
                    Film::distinct()->with('detail','film_genres.genres')->get()
                );
            });

            return response()->json([
                'status' => 'success',
                'message' => 'list film',
                "data" => $films
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function showDetail($id)
    {
        cache()->clear();
        try {
            $films = cache()->remember("detail-film-$id", 60*60*24, function () use ($id) {
                return FilmDetailsResource::collection(
                    Film::with('film_genres.genres', 'detail', 'aktors','detail.creator')->whereId($id)->get()
                );
            });
            return response()->json([
                'detail_film' => $films,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cari($judul)
    {
        // cache()->clear();
        try {
            $films = FilmResource::collection(
                Film::distinct()->with('detail','film_genres.genres')->where('judul', 'like', "%$judul%")->get()
            );
            return response()->json([
                'film' => $films,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function cari_genre($genre)
    {
        // cache()->clear();
        try {
            $genre = Genre::where('name', $genre)->get();
            // dd($genre);
            $films = FilmResource::collection(
                Film::distinct()
                    ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
                    ->join('film_details', 'films.id', '=', 'film_details.film_id')
                    ->selectRaw('films.id, films.judul, films.tumbnail, film_details.tahun, film_details.rating, film_details.kunjungan')
                    ->where('film_genre.genre_id', $genre[0]->id)
                    ->get()
            );

            return response()->json([
                'film' => $films,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
