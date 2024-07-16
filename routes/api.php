<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ProtectedRouteAuth;
use App\Http\Middleware\RespondWithJsonMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(RespondWithJsonMiddleware::class)->group(function () {
    Route::apiResource('/login', AuthController::class);
    Route::apiResource('/users', UserController::class)->only('store');

    Route::middleware(ProtectedRouteAuth::class)->group(function () {
        Route::apiResource('/despesas', DespesaController::class);
        Route::apiResource('/users', UserController::class)->except('store');
    });
});
