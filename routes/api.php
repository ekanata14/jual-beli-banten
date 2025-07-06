<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingPageController;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
})->name('api.ping');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/checkout/callback', [LandingPageController::class, 'midtransCallbackAPI'])->name('api.checkout.callback');
