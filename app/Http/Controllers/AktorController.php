<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktorRequest;
use App\Models\Aktor;
use App\Models\Film;
use Illuminate\Http\Request;

class AktorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aktors = Aktor::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $films = Film::all();
        return view('pages.aktor.create', compact('films'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AktorRequest $request)
    {
       try {
            $data = $request->all();
            $data['gambar'] = $request->file('gambar')->store(
                'assets/Aktor',
                'public'
            );

            Aktor::create($data);
       } catch (\Exception $err) {
           throw $err->getMessage();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aktor = Aktor::findOrFail($id);
        return view('pages.aktor.edit',compact('aktor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AktorRequest $request, $id)
    {
        $aktor = Aktor::findOrFail($id);

        try {
            $data = $request->all();
            $data['gambar'] = $request->file('gambar')->store(
                'assets/Aktor',
                'public'
            );
            $aktor->update($data);
        } catch (\Exception $err) {
            throw $err->getMessage();
        }

        return view('pages.film.index');
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
            Aktor::findOrFail($id)->delete();
       } catch (\Exception $err) {
           throw $err->getMessage();
       }
        return view('pages.film.index');
    }
}
