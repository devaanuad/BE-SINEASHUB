<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedFilm extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','film_id'];

    public function user()
    {
        $this->hasMany(User::class);
    }

    public function films(){
        return $this->hasMany(Film::class);
    }
}
