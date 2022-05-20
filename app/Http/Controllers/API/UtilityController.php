<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\LikedFilm;
use App\Models\Film;
use App\Models\FilmGenre;
use App\Models\FilmDetails;
use App\Models\Transaction;

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
                return FilmDetails::with('film:id,tumbnail,judul')
                    ->select('film_id','rating','kunjungan')->orderBy('kunjungan', 'desc')->limit(100)->get();
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
        try {
            $film_favorit = cache()->remember('terfavorit',60*60*24,function(){
                return LikedFilm::join('films','films.id','=','liked_films.film_id')
                    ->selectRaw('films.id,films.judul,films.tumbnail, count(*) as jumlah')
                    ->groupBy('films.id')
                    ->orderBy('jumlah','desc')
                    ->limit(100)
                    ->get();
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
                return Film::distinct()
                    ->join('film_genres','films.id','=','film_genres.film_id')
                    ->whereIntegerInRaw('film_genres.genre_id',array_unique($data_genre))
                    ->selectRaw('films.id,films.judul,films.tumbnail,film_genres.genre_id')
                    ->limit(100)
                    ->get();
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
                return LikedFilm::distinct()->join('films','films.id','=','liked_films.film_id')
                    ->where('liked_films.user_id',\Auth::id())->selectRaw('films.id,films.judul,films.tumbnail')
                    ->get();
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
}
