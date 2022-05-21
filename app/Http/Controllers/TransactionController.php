<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        return view('pages.transaction.index', compact('transactions'));
    }

    public function updateTransaction($transaction_id){
       try {
            $transaction = Transaction::findOrFail($transaction_id);
            

       } catch (\Throwable $th) {
           //throw $th;
       }
        

    }
}
