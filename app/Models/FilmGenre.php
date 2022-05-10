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

    protected $hidden = [
        'id',
        'film_id',
        'created_at',
        'updated_at',
    ];

    public function genres() {
        return $this->hasMany(Genre::class,'id','genre_id');
    }
}
