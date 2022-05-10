<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Models\FilmDetails;
use App\Models\FilmGenre;

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
                return Film::with('film_genres.genres','creator', 'detail:film_id,rating,tanggal_terbit,kunjungan')->get();
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
        // cache()->clear();
        try {
            $films = cache()->remember("detail-film-$id", 60*60*24, function () use ($id) {
                return Film::with('film_genres.genres', 'detail', 'aktors', 'creator')->where('id', $id)->get();
            });
            return response()->json([
                'detail_film' => $films,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'tidak dapat menemukan detail film'//$e->getMessage()
            ], 500);
        }
    }

    public function cari($judul)
    {
        // cache()->clear();
        try {
            $films = cache()->remember("detail-film-$judul", 60*60*24, function () use ($judul) {
                return Film::with('film_genres.genres')->where('judul','like', "$judul%")->get();
            });
            return response()->json([
                'film' => $films,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'tidak dapat menemukan detail film'//$e->getMessage()
            ], 500);
        }
    }
}
