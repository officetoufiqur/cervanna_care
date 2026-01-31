<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/home', 'home');
    Route::get('/services', 'services');
    Route::get('/abouts', 'abouts');
    Route::get('/events', 'events');
    Route::get('/contacts', 'contacts');
    Route::get('/blogs', 'blogs');
    Route::get('/skills', 'skillNurse');
    Route::get('/price', 'prices');
    Route::get('/specialist', 'specialist');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/verify', 'verifyOtp');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/create-profile', [AuthController::class, 'create_profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/booking', [AuthController::class, 'booking']);
});
