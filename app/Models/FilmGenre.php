<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmGenre extends Model
{
    use HasFactory;
    protected $fillable = ['genre_id','film_id'];

    public function film(){
        return $this->belongsTo(Film::class);
    }
}
