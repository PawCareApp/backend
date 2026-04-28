<?php

use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::get('', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::post('/register-customer', [UserController::class, 'registerCustomer']);
// Route::get('/test', function () {
//     return 'API OK';
// });
// Route::get('/get-customer/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::put('/edit-profile', [UserController::class, 'editProfile']);
    Route::patch('/edit-profile', [UserController::class, 'editProfile']);
    Route::apiResource('pets', PetController::class);
    Route::post('/pets/{id}/restore', [PetController::class, 'restore']);
});