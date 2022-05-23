<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'url_film' => $this->url_film,
            'rating' => $this->rating,
            'harga' => $this->harga,
            'tahun' => $this->tahun,
            'tanggal_terbit' => $this->tanggal_terbit,
            'kunjungan' => $this->kunjungan
        ];
    }
}
