<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'film_id'];

    public function detail(){
        return $this->hasOne(DetailTransaction::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function film(){
        return $this->hasOne(Film::class);
    }

}
