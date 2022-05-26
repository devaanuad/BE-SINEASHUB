<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function film_details(){
        return $this->belongsTo(FilmDetails::class,'creator_id');
    }
}
