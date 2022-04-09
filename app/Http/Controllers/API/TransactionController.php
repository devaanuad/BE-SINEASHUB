<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaction;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //lakukan transaksi
    public function store(Request $request)
    {
        //create transaction
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'film_id' => $request->film_id,
            'status' => 'pending',
        ]);

        //create detail transaction
        $detail_transaction = DetailTransaction::create([
            'transaction_id' => $transaction->id,
            'nama_film' => $request->nama_film,
            'harga_beli' => $request->harga_beli,
            'tanggal_beli' => Carbon::now()->format('Y-m-d'),
            'tanggal_berakhir' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil',
            'data' => $detail_transaction,
            ]);
    }
}
