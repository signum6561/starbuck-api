<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;


Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('auth:api');
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:api'], function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
});
