<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktor extends Model
{
    use HasFactory;

    protected $fillable =[
        'film_id','nama','gambar'
    ];

    public function film(){
        $this->belongsTo(Film::class);
    }
}
