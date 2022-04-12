<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use App\Models\FilmDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::all();

        return view('pages.film.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.film.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {

        // create film
        $film = Film::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tumbnail' => $request->tumbnail,
            'url_trailer' => $request->url_trailer,
            'status' => $request->status,
        ]);

        // create detail films
        FilmDetails::create([
            'film_id' => $film->id,
            'url_film' => $request->url_film,
            'tahun' => Carbon::now()->format('Y'),
            'tanggal_terbit' => $request->tanggal_terbit,
            'harga' => $request->harga,
        ]);

        return redirect()->route('film.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = FilmDetails::where('film_id', $id)->first();
        return view('pages.film.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $film = Film::findOrFail($id);
        return view('pages.film.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilmRequest $request, $id)
    {
        $film = Film::findOrFail($id);
        $film->update($request->all());
        return redirect()->route('film.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Film::findOrFail($id)->delete();

            return redirect()->route('film.index');
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function satu($id)
    {
        $films = Film::where('id', $id)->get();
        return response()->json(['film' => $films],200);
    }
    public function semua()
    {
        return response()->json(
            [

            ],
        );
        $films = Film::all();
        return response()->json(['film' => $films],200);
    }

    public function filmDetail($id)
    {
        $films = FilmDetails::where('film_id', $id)->get();
        return response()->json(['detail_film' => $films],200);
    }
}