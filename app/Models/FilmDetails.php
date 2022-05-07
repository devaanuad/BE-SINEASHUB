<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'url_film',
        'rating',
        'tahun',
        'tanggal_terbit',
        'harga',
        'kunjungan',
        'sutradara'
    ];

    public function film() {
        return $this->belongsTo(Film::class);
    }
}
