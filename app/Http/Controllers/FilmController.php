<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use App\Models\FilmDetails;
use App\Models\FilmGenre;
use App\Models\Genre;
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
        $films = Film::with("genres", "detail","aktors")->get();
        return response()->json($films, 200);

        return view('pages.film.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('pages.film.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {

        try {
            // simpan gambar
            $request->file('tumbnail')->store(
                'assets/tumbnail',
                'public'
            );

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

            // simpan data relasi film genre
            // foreach ($request->genre_id as $genre) {
            //     $filmGenre[] = new FilmGenre([
            //         "film_id" => $film->id,
            //         "genre_id" => $genre
            //     ]);
            // }
            // create relasi film genre
            $film->genres()->attach($request->genre_id);
        } catch (\Exception $err) {
            dd($err->getMessage());
        }

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
}
