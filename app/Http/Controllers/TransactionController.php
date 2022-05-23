<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = DetailTransaction::with(['transaction.user'])->where('status', 'pending');

        $transactions->when($request->cari, function ($q) use ($request){
                            $q->whereHas('transaction.user', function ($q) use ($request){
                                $q->where('name', 'like', "%{$request->cari}%");
                            });
                        });

        return view('pages.transaction.index')->with([
            'transactions' => $transactions->get()
        ]);
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
