<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Balance\BalanceController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\Exchange\ExchangeController;
use App\Http\Controllers\Rate\RateController;
use App\Http\Controllers\Topup\TopupController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Withdrawal\Webhooks\XenditController;
use App\Http\Controllers\Withdrawal\WithdrawalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function(){
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');

Route::get('/rates', [RateController::class, 'index'])->name('rates.index');
Route::get('/rates/{pair}', [RateController::class, 'get'])->name('rates.get');

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('/profile')->as('profile.')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('index');
    });

    Route::prefix('/balances')->as('balances.')->group(function(){
        Route::get('/', [BalanceController::class, 'index'])->name('index');
        Route::post('/{currency}', [BalanceController::class, 'create'])->name('create');
    });

    Route::prefix('/exchanges')->as('exchanges.')->group(function(){
        Route::post('/', [ExchangeController::class, 'exchange'])->name('create');
    });

    Route::prefix('/transactions')->as('transactions.')->group(function(){
        Route::get('/', [TransactionController::class, 'index'])->name('index');
    });

    Route::prefix('/topups')->as('topups.')->group(function(){
        Route::post('/', [TopupController::class, 'create'])->name('create');
    });

    Route::prefix('/withdrawals')->as('withdrawals.')->group(function(){
        Route::post('/', [WithdrawalController::class, 'withdraw'])->name('create');
    });
});

// Webhooks
Route::prefix('/webhooks')->as('webhooks.')->group(function(){
    Route::prefix('/xendit')->as('xendit.')->group(function(){
        Route::post('/withdrawal', [XenditController::class, 'webhook'])->name('disbursement');
        Route::post('/invoice', [XenditController::class, 'invoice'])->name('invoice');
    });
});
