<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlController;
use Illuminate\Support\Facades\Route;


//API Token generator
Route::post('/token/generate', [AuthController::class, 'generate'])->name('api.token.generate');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/urls', [UrlController::class, 'index']);
    Route::get('/urls/{uuid}', [UrlController::class, 'get']);
    Route::post('/urls', [UrlController::class, 'store']);
    Route::put('/urls/{uuid}', [UrlController::class, 'update']);
    Route::delete('/urls/{uuid}', [UrlController::class, 'destroy']);
});
