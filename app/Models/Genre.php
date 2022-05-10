<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['created_at','updated_at'];

    public function films()
    {
        return $this->belongsTo(Film::class);
    }

    public function film_genres()
    {
        return $this->belongsToMany(FilmGenre::class);
    }

}
