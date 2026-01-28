<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ChooseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FoundationController;
use App\Http\Controllers\OurCoreController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorksController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use Illuminate\Support\Facades\Artisan;

Route::get('/storage-link', function () {
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');

    return "Storage link created successfully";
});

Route::get('/', function () {
    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'is_not_admin', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_not_admin'])->group(function () {
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

    Route::resource('/faqs', FaqController::class);

    Route::controller(FaqController::class)->group(function () {
        Route::get('/faqs/header/edit/{id}', 'faqsEdit')->name('faqs.header.edit');
        Route::post('/faqs/header/update/{id}', 'faqsUpdate')->name('faqs.header.update');
    });

    Route::resource('/chooses', ChooseController::class);
    Route::resource('/services', ServiceController::class);
    Route::controller(ServiceController::class)->group(function () {
        Route::get('/service/header/edit/{id}', 'serviceEdit')->name('service.edit');
        Route::post('/service/header/update/{id}', 'serviceUpdate')->name('service.update');
    });

    Route::resource('/works', WorksController::class);

    Route::controller(AboutController::class)->group(function () {
        Route::get('/about', 'index')->name('about.index');
        Route::get('/about/edit/{id}', 'edit')->name('about.edit');
        Route::post('/about/update/{id}', 'update')->name('about.update');
    });

    Route::resource('/our-cores', OurCoreController::class);
    Route::resource('/foundation', FoundationController::class);
    Route::resource('/events', EventController::class);
    Route::resource('/contacts', ContactController::class);
    Route::get('/contacts/header/edit/{id}', [ContactController::class, 'contactEdit'])->name('contact.edit');
    Route::post('/contact/header/update/{id}', [ContactController::class, 'contactUpdate'])->name('contact.update');

});

require __DIR__.'/settings.php';
