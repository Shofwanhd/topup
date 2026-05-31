<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;

        $transaction = Transaction::where(
            'id_transaksi',
            $orderId
        )->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        if (
            $transactionStatus == 'settlement' ||
            $transactionStatus == 'capture'
        ) {
            $transaction->update([
                'status' => 'PAID'
            ]);
        }

        if (
            $transactionStatus == 'expire'
        ) {
            $transaction->update([
                'status' => 'EXPIRED'
            ]);
        }

        if (
            $transactionStatus == 'cancel'
        ) {
            $transaction->update([
                'status' => 'CANCELLED'
            ]);
        }

        return response()->json([
            'message' => 'OK'
        ]);
    }
}
