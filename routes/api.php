<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinancialSummaryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('transacoes', [TransactionController::class, 'store']);
    Route::get('transacoes', [TransactionController::class, 'index']);
    Route::get('transacoes/{id}', [TransactionController::class, 'show']);
    Route::put('transacoes/{id}', [TransactionController::class, 'update']);
    Route::delete('transacoes/{id}', [TransactionController::class, 'destroy']);

    Route::get('resumo', [FinancialSummaryController::class, 'getSummary']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
