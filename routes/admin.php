<?php

use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\ExchangeController;
use App\Http\Controllers\Admin\HedgeController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\UserBanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WithdrawalController;

Route::prefix('/users')->as('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::prefix('/{user}')->group(function(){
        Route::get('/', [UserController::class, 'get'])->name('get');
        Route::prefix('/bans')->as('bans.')->group(function(){
            Route::post('/', [UserBanController::class, 'create'])->name('create');
            Route::patch('/', [UserBanController::class, 'update'])->name('update');
            Route::delete('/', [UserBanController::class, 'delete'])->name('delete');
        });
    });
});

Route::prefix('/currencies')->as('currencies.')->group(function(){
    Route::get('/', [CurrencyController::class, 'index'])->name('index');
    Route::prefix('/{currency}')->group(function(){
        Route::get('/', [CurrencyController::class, 'get'])->name('get');
        Route::patch('/', [CurrencyController::class, 'update'])->name('update');
    });
});

Route::prefix('/exchanges')->as('exchanges.')->group(function(){
    Route::get('/', [ExchangeController::class, 'index'])->name('index');
    Route::prefix('/{exchange}')->group(function(){
        Route::get('/', [ExchangeController::class, 'get'])->name('get');
        Route::post('/hedge/cancel', [HedgeController::class, 'cancel'])->name('hedge.cancel');
    });
});

Route::prefix('/topups')->as('topups.')->group(function(){
    Route::get('/', [TopupController::class, 'index'])->name('index');
    Route::prefix('/{topup}')->group(function(){
        Route::get('/', [TopupController::class, 'get'])->name('get');
    });
});

Route::prefix('/withdrawals')->as('withdrawals.')->group(function(){
    Route::get('/', [WithdrawalController::class, 'index'])->name('index');
    Route::prefix('/{withdrawal}')->group(function(){
        Route::get('/', [WithdrawalController::class, 'get'])->name('get');
    });
});
