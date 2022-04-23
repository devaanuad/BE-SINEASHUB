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
        ]);

        //create detail transaction
        $detail_transaction = DetailTransaction::create([
            'transaction_id' => $transaction->id,
            'nama_film' => $request->nama_film,
            'harga_beli' => $request->harga_beli,
            'tanggal_beli' => Carbon::now()->format('Y-m-d'),
            'tanggal_berakhir' => Carbon::now()->addHours($request->film_expire)->format('Y-m-d'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil',
            'data' => $detail_transaction,
            ]);
    }

    //midtrans transaction
    public function midtrans(Request $request)
    {
        try{
            \Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $user = User::where('id', \Auth::id())->first();
            $params = array(
                'transaction' => array(
                    'film_id' => $request->film_id,
                    'user_id' => \Auth::id()
                ),
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $request->harga_beli + 2500, //2500 biaya admin sementara sampe ditentuin
                    'transaction_id' => $transaction->id,
                    'nama_film' => $request->nama_film,
                    'harga_beli' => $request->harga_beli,
                    'tanggal_beli' => Carbon::now()->format('Y-m-d'),
                    'tanggal_berakhir' => Carbon::now()->addHours($request->film_expire)->format('Y-m-d'),
                ),
                'user_details' => array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->no_hp ? $user->no_hp : '-',
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json([
                'transaction_token' => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken"
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
