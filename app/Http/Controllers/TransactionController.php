<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = DetailTransaction::with(['transaction.user'])
                        ->where('status', 'pending')->get();

        // $transactions = Transaction::with(['user', 'detail' => function($q) {
        //     $q->where('status','pending');
        // }])->get();

        // return response()->json($transactions, 200);

        return view('pages.transaction.index', compact('transactions'));
    }

    public function update($transaction_id){
       try {
            $transaction = Transaction::with('detail')->findOrFail($transaction_id);
            $transaction->detail->status = 'success';
            $transaction->detail->save();
       } catch (\Throwable $th) {
           throw $th->getMessage();
       }

        return redirect()->route('transaction.index')->with('success', 'Transaction has been updated');
    }
}
