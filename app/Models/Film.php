<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'deskripsi', 'tumbnail','url_trailer', 'status'
    ];

    protected $appends = ['liked','rating'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function genres(){
        return $this->belongsToMany(Genre::class);
    }

    public function detail()
    {
        return $this->hasOne(FilmDetails::class);
    }

    public function aktors()
    {
        return $this->hasMany(Aktor::class);
    }

    public function film_genres(){
        return $this->hasMany(FilmGenre::class);
    }

    public function liked_films()
    {
        return $this->hasMany(LikedFilm::class);
    }

    public function getLikedAttribute(){
        return $this->liked_films()->count();
    }

    //get average rating attribute
    public function getRatingAttribute(){
        return $this->hasMany(Rating::class)->selectRaw('truncate(avg(rating),1) as rating')->first()->rating;
    }
}
