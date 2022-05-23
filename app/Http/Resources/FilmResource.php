<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $newArr = [];
        foreach($this->film_genres as $gen){
            array_push($newArr,$gen->genres[0]->name);
        }
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'thumbnail' => $this->tumbnail,
            'liked' => $this->liked,
            'rating' => $this->rating,
            'view' => $this->kunjungan,
            'tahun' => $this->tahun,
            'film_genres' => array_unique($newArr),
        ];
    }
}
