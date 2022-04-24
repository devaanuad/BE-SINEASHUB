<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Models\FilmDetails;

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
            $films = Film::with('detail', 'aktors', 'genres')->get();
            return response()->json([
                'list_film' => $films,
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'terjadi kesalahan saat mendapatkan daftar film'//$e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDetail($id)
    {
        try {
            $films = Film::with('detail')->where('id',$id)->get();
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
}
