<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_id', 'nama_film', 'harga_beli', 'tanggal_beli', 'tanggal_berakhir', 'status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
