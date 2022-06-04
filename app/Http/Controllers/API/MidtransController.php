<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    // notification midtrans
    public function MidtransNotification(Request $request)
    {
        // set konfigurasi mitrans
        config::$serverKey = config('midtrans.serverKey');
        config::$isProduction = config('midtrans.isProduction');
        config::$isSanitized = config('midtrans.isSanitized');
        config::$is3ds = config('midtrans.is3ds');

        // ambil data dari midtrans
        $notif = new Notification();

        // Assign ke variable
        $status = $notif->status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;
        $order_id = $notif->order_id;

        // cari transaction berdasarkan id
        $transaction = Transaction::findOrFail($order_id);

        // hendler notification midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->detail->status = 'challenge';
                } else {
                    $transaction->detail->status = 'success';
                }
            }
        } elseif ($status == 'settlement') {
            $transaction->detail->status = 'success';
        } elseif ($status == 'pending') {
            $transaction->detail->status = 'pending';
        } elseif ($status == 'deny') {
            $transaction->detail->status = 'failed';
        } elseif ($status == 'expire') {
            $transaction->detail->status = 'expired';
        } elseif ($status == 'cencel') {
            $transaction->detail->status = 'failed';
        }

        // simpan transaction detail
        $transaction->detail->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Notification berhasil'
            ],
            200
        );
    }


    public function finis()
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => 'transaction success'
            ],
        );
    }

    public function unfinis()
    {
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'transaction failed'
            ],
        );
    }

    public function error()
    {
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'transaction failed'
            ],
        );
    }
}
