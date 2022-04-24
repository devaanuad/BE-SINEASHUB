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
            $films = Film::with('genres', 'detail', 'aktors')->get();
            if (empty($films)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'list film',
                    "data" => []
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'list film',
            "data" => $films
        ]);
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
            $films = Film::with('detail')->where('id', $id)->get();
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
