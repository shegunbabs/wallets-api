<?php

use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group( static function(){

    Route::prefix('wallets')->group( static function()
    {
        Route::post('create', [WalletController::class, 'create']);
    });

});
