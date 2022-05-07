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
            $trending_film = FilmDetails::with('film')->orderBy('kunjungan', 'desc')->get();
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
            $film_favorit = LikedFilm::selectRaw('film_id, count(film_id) as jumlah')->groupBy('film_id')->orderBy('jumlah','desc')->get();
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

    public function rekomendasi()
    {
        try {
            $data_genre = [];
            $filtered_film = [];

            $trans = Transaction::with('detail')->where('user_id', \Auth::id())->get();
            foreach ($trans as $data) {
                $genre = FilmGenre::where('film_id', $data->film_id)->get();
                foreach($genre as $j){
                    array_push($data_genre, $j->genre_id);
                }
            }
            foreach (array_unique($data_genre) as $data) {
                $film = Film::distinct()->join('film_genres','films.id','=','film_genres.film_id')->where('film_genres.genre_id',$data)->selectRaw('films.*,film_genres.genre_id')->get();
                array_push($filtered_film, $film);
            }

            return response()->json([
                'status' => 'success',
                'data' => array_unique($filtered_film)
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
            $liked_film = LikedFilm::join('films','films.id','=','liked_films.film_id')->where('liked_films.user_id',\Auth::id())->selectRaw('films.*')->get();
            return response()->json([
                'status' => 'success',
                'data' => $liked_film
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ]);
        }
    }
}
