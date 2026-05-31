<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['id_transaksi', 'name', 'email', 'phone', 'product', 'variation', 'amount', 'status', 'status_payment', 'message', 'payment_method', 'snap_token', 'midtrans_order_id', 'midtrans_transaction_id'])]
class Transaction extends Model
{
    protected static function booted(): void
    {
        static::creating(function ($transaction) {
            $transaction->id_transaksi = 'INV' . now()->format('Ymd') . Str::upper(Str::random(6));
        });
    }
}
