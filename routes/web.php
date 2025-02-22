<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transactionResult', function () {
    return view('transactionResult');
});

Route::get('/transactionList', [DepositController::class, 'index']);

Route::post('/deposit', [DepositController::class, 'store']);

Route::post('/webhook/{myTransactionId}', [DepositController::class, 'webhook']);
