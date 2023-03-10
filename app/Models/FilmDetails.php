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
        'creator_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function film() {
        return $this->belongsTo(Film::class);
    }

    public function creator() {
        return $this->hasOne(Creator::class,'id','creator_id');
    }
}
