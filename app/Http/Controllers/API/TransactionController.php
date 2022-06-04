<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class TransactionController extends Controller
{
    //lakukan transaksi
    public function store(Request $request)
    {
        //create transaction
        try {
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
                'tanggal_berakhir' => Carbon::now()->addHours($request->film_expire)->format('Y-m-d')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil',
                'data' => $detail_transaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'terjadi kesalahan saat melakukan transaksi'//$e->getMessage()
            ],500);
        }
    }

    // lakukan pembayaran mitrans
    public function transaction($id)
    {
        $transaction = DetailTransaction::with('transaction.user')->findOrFail($id);

        // return response()->json($transaction);

        // set konfigurasi mitrans
        config::$serverKey = config('midtrans.serverKey');
        config::$isProduction = config('midtrans.isProduction');
        config::$isSanitized = config('midtrans.isSanitized');
        config::$is3ds = config('midtrans.is3ds');

        // buat array untuk di kirim midtrans
        $params = array(
            'transactions' => array(
                'film_id' => $transaction->film_id, //$request->film_id,
                'user_id' => 1
            ),
            'transaction_details' => array(
                'order_id' => $transaction->id,
                'gross_amount' =>  (int) $transaction->total_harga + 2500, //$request->harga_beli + 2500, //2500 biaya admin sementara sampe ditentuin
                'transaction_id' =>   $transaction->transaction_id, //$transaction->id,
                'nama_film' =>   $transaction->nama_film, //$request->nama_film,
                'harga_beli' =>   $transaction->total_harga, //$request->harga_beli,
                'tanggal_beli' => Carbon::now()->format('Y-m-d'),
                'tanggal_berakhir' => Carbon::now()->addHours($transaction->tanggal_berakhir)->format('Y-m-d'),
            ),
            'customer_details' => array(
                'first_name' => $transaction->transaction->user->name,
                'email' => $transaction->transaction->user->email,
            ),
            'enabled_payments' => array('credit_card', 'bank_transfer', 'gopay'),
            'credit_card' => array(
                'secure' => true
            ),
            // "expiry"=> array(
            //     "start_time" => Carbon::now()->format('yyyy-MM-dd hh:mm:ss'),
            //     "unit" => "minutes",
            //     "duration"=> 5
            // ),
            'vtweb' => array()
        );
        // dd($params);

        try {
            // ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($params)->redirect_url;

            return response()->json(
                [
                    'url' => $paymentUrl,
                ],200
            );


        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'massage' => $e->getMessage()
                ], $e->getCode()
            );
        }

    }

    //midtrans transaction
    public function midtrans(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey = 'SB-Mid-server-0PLmsmjandYEXvNR8-54jM_T';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $user = User::where('id', Auth::id())->first();
            $params = array(
                'transaction' => array(
                    'film_id' => 1,//$request->film_id,
                    'user_id' => request()->user()->id
                ),
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' =>   61000,//$request->harga_beli + 2500, //2500 biaya admin sementara sampe ditentuin
                    'transaction_id' =>   90,//$transaction->id,
                    'nama_film' =>   'bla',//$request->nama_film,
                    'harga_beli' =>   56000,//$request->harga_beli,
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function get_user_transaction(){
        try {
            $trans = Transaction::with('detail')->where('user_id',Auth::id())->get();
            return response()->json([
                'status' => 'success',
                'data' => $trans
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ],500);
        }
    }
}
