<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register-customer', [\App\Http\Controllers\Api\UserController::class, 'registerCustomer']);
Route::get('/test', function () {
    return 'API OK';
});