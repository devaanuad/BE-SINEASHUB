<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function film(){
        return $this->hasMany(Film::class,'id','creator_id');
    }
}
