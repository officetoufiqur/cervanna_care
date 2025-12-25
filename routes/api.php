<?php

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
});