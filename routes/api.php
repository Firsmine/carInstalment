<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Image\Transformations\Rotate;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::middleware('auth:santum')->group(function () {
        // validation
        Route::get('/validations', [ValidationController::class, 'index']);
        Route::post('/validations', [ValidationController::class, 'store']);
        // installment
        Route::get('/installment_cars', [InstallmentController::class, 'index']);
        Route::get('/installment_cars/{id}', [InstallmentController::class, 'show']);
        // application
        Route::post('applications', [ApplicationController::class, 'store']);
        Route::get('applications', [ApplicationController::class, 'index']);
    });
});
