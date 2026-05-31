<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::index');
Route::livewire('/product/{slug}', 'pages::product');
Route::livewire('/transaction', 'pages::transaction');
Route::livewire('/transaction/{id_transaksi}', 'pages::transactiondetail');


// Route::post('/midtrans/callback', [MidtransController::class, 'callback']);
