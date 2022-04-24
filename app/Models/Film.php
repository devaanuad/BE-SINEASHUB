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

}
