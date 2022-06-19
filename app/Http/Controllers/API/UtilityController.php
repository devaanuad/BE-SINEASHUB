<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\LikedFilm;
use App\Models\Film;
use App\Models\FilmGenre;
use App\Models\FilmDetails;
use App\Models\Transaction;
use App\Models\Genre;
use App\Http\Resources\FilmResource;
use App\Models\Rating;

class UtilityController extends Controller
{
    public function like_dislike(Request $req)
    {
        $status = $req->status;

        try {
            if ($status === 'like') {
                LikedFilm::create(
                    [
                        'film_id' => $req->film_id,
                        'user_id'=> \Auth::id()
                    ]
                );
                return response()->json([
                    'status' => 'success',
                    'message' => 'film berhasil ditambahkan ke favorit'
                ]);
            } elseif ($status === 'dislike') {
                LikedFilm::where(['user_id' => \Auth::id(),'film_id' => $req->film_id])->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'film berhasil dihapus dari favorit'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'status harus like atau dislike'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    public function trending(Request $req)
    {
        try {
            $trending_film = cache()->remember('trending',60*60*24,function (){
                return FilmResource::collection(
                    Film::distinct()
                        ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
                        ->join('film_details', 'films.id', '=', 'film_details.film_id')
                        ->selectRaw('films.id, films.judul, films.tumbnail, film_details.tahun, film_details.rating, film_details.kunjungan')
                        ->limit(100)
                        ->get()->sortBy('kunjungan',0,'desc')
                );
            });
            return response()->json([
                'status' => 'success',
                'data' => $trending_film
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function terfavorit(Request $req)
    {
        // cache()->clear();
        try {
            $film_favorit = cache()->remember('terfavorit',60*60*24,function(){
                return FilmResource::collection(
                    Film::distinct()
                        ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
                        ->join('film_details', 'films.id', '=', 'film_details.film_id')
                        ->selectRaw('films.id, films.judul, films.tumbnail, film_details.tahun, film_details.rating, film_details.kunjungan')
                        ->limit(100)
                        ->get()->sortBy('liked',0,'desc')
                );
            });
            return response()->json([
                'status' => 'success',
                'data' => $film_favorit
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function terkait()
    {
        // cache()->clear();
        try {
            $data_genre = [];
            $filtered_film = [];

            $trans = Transaction::with('detail:film_id')->where('user_id', \Auth::id())->get();
            foreach ($trans as $data) {
                $genre = FilmGenre::where('film_id', $data->film_id)->get();
                foreach($genre as $j){
                    array_push($data_genre, $j->genre_id);
                }
            }
            $film = cache()->remember('terkait',60*60*24,function () use ($data_genre) {
                return FilmResource::collection(
                    Film::distinct()
                    ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
                    ->join('film_details', 'films.id', '=', 'film_details.film_id')
                    ->selectRaw('films.id, films.judul, films.tumbnail, film_details.tahun, film_details.rating, film_details.kunjungan')
                    ->limit(100)
                    ->whereIntegerInRaw('film_genre.genre_id',array_unique($data_genre))
                    ->get()
                );
            });

            return response()->json([
                'status' => 'success',
                'data' => $film
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function get_liked_film(){
        try {
            $liked_film = cache()->remember('liked-film',60*60*24,function (){
                return  FilmResource::collection(
                    Film::distinct()
                        ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
                        ->join('film_details', 'films.id', '=', 'film_details.film_id')
                        ->join('liked_films','films.id','=','liked_films.film_id')
                        ->selectRaw('films.id, films.judul, films.tumbnail, film_details.tahun, film_details.rating, film_details.kunjungan')
                        ->limit(100)
                        ->where('liked_films.user_id',\Auth::id())
                        ->get()
                );
            });
            return response()->json([
                'status' => 'success',
                'data' => $liked_film
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ],500);
        }
    }

    public function get_genre(){
        try {
            $genre = cache()->remember('genre',60*60*24,function (){
                return Genre::pluck('name');
            });
            return response()->json([
                'status' => 'success',
                'data' => $genre
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ],500);
        }
    }

    public function user_rating(Request $req){
        try {
            Rating::create([
                'user_id' => \Auth::id(),
                'film_id' => $req->film_id,
                'rating' => $req->rating
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Rating berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ],500);
        }
    }
}
