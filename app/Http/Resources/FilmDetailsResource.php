<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmDetailsResource extends JsonResource
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
            'deskripsi' => $this->deskripsi,
            'url_trailer' => $this->url_trailer,
            'status' => $this->status,
            'film_genres' => array_unique($newArr),
            'aktors' => AktorResource::collection($this->aktors),
            'details' => new FilmDetailResource($this->detail),
            'creator' => $this->creator
        ];
    }
}
