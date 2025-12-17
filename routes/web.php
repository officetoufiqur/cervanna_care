<?php

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(BannerController::class)->group(function () {
        Route::get('/banners', 'index')->name('banners.index');
        Route::get('/banners/create', 'create')->name('banners.create');
        Route::post('/banner/store', 'store')->name('banners.store');
        Route::get('/banner/edit/{id}', 'edit')->name('banners.edit');
        Route::post('/banner/update/{id}', 'update')->name('banners.update');
        Route::delete('/banner/delete/{id}', 'delete')->name('banners.delete');
        Route::get('/news-letters', 'newsLetters')->name('news-letters');
        Route::get('/news-letters/edit/{id}', 'newsLettersEdit')->name('news-letters.edit');
        Route::post('/news-letters/update/{id}', 'newsLettersUpdate')->name('news-letters.update');
    });
});

require __DIR__.'/settings.php';
