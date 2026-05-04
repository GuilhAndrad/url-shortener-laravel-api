<?php

use App\Http\Controllers\Api\V1\UrlController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/shorten', [UrlController::class, 'store'])
        ->middleware('throttle:shorten_create');

    Route::middleware('throttle:api')->group(function () {
        Route::get('/shorten/{code}', [UrlController::class, 'show']);
        Route::put('/shorten/{code}', [UrlController::class, 'update']);
        Route::delete('/shorten/{code}', [UrlController::class, 'destroy']);
        Route::get('/shorten/{code}/stats', [UrlController::class, 'stats']);
    });
});