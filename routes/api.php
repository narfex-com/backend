<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Balance\BalanceController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('/profile')->as('profile.')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('index');
    });

    Route::prefix('/balances')->as('balances.')->group(function(){
        Route::get('/', [BalanceController::class, 'index'])->name('index');
    });
});
