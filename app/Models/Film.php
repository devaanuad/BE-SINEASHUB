<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
            'judul', 'deskripsi','tumbnail','url_trailer'
    ];

    // public function filmDetail(){
    //     return $this->hasOne();
    // }
}
