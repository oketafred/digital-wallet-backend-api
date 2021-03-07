<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobileMoneyDepositController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('/pincheck', [AuthController::class, 'pincheck']);
  // Deposit
  Route::post('/mmdeposit', [MobileMoneyDepositController::class, 'mmdeposit']);
});
