<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AgencyEmployController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChooseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FoundationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\InstitutionEmployController;
use App\Http\Controllers\OurCoreController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorksController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/storage-link', function () {
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');

    return 'Storage link created successfully';
});

Route::get('/', function () {
    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'is_not_admin', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_not_admin', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
});

Route::middleware(['auth', 'is_not_admin'])->group(function () {
    Route::post('/notifications/{id}/read', function ($id) {
        DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);

        return back();
    });

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
    Route::resource('/price', PriceController::class)->names('price');

    Route::controller(AboutController::class)->group(function () {
        Route::get('/about', 'index')->name('about.index');
        Route::get('/about/edit/{id}', 'edit')->name('about.edit');
        Route::post('/about/update/{id}', 'update')->name('about.update');
        Route::get('/subscribe', 'subscriber')->name('subscribe');
    });

    // Route::controller(PlanController::class)->group(function () {
    //     Route::get('/plan', 'index')->name('plan.index');
    //     Route::get('/plan/create', 'create')->name('plan.create');
    //     Route::post('/plan/store', 'store')->name('plan.store');
    //     Route::get('/plan/edit/{id}', 'edit')->name('plan.edit');
    //     Route::put('/plan/update/{id}', 'update')->name('plan.update');
    //     Route::delete('/plan/delete/{id}', 'delete')->name('plan.delete');
    // });

    Route::resource('/plan', PlanController::class)->names('plan');

    Route::controller(UserController::class)->group(function () {
        Route::get('/all-user', 'userIndex')->name('all-user.index');
        Route::get('/user/create', 'userCreate')->name('user.create');
        Route::post('/user/store', 'userStore')->name('user.store');
        Route::get('/user/edit/{id}', 'userEdit')->name('user.edit');
        Route::put('/user/update/{id}', 'userUpdate')->name('user.update');

        Route::get('/specialist/edit/{id}', 'specialistEdit')->name('specialist.edit');
        Route::put('/specialist/update/{id}', 'specialistUpdate')->name('specialist.update');

        Route::get('/all-agency', 'agencyIndex')->name('agency.index');
        Route::get('/agency/create', 'agencyCreate')->name('agency.create');
        Route::post('/agency/store', 'agencyStore')->name('agency.store');
        Route::get('/agency/edit/{id}', 'agencyEdit')->name('agency.edit');
        Route::put('/agency/update/{id}', 'agencyUpdate')->name('agency.update');
    });

    Route::controller(AgencyEmployController::class)->group(function () {
        Route::get('/agency-employees', 'index')->name('agency-employees.index');
        Route::get('/agency-employee/create', 'create')->name('agency-employee.create');
        Route::post('/agency-employee/store', 'store')->name('agency-employee.store');
        Route::get('/agency-employee/edit/{id}', 'edit')->name('agency-employee.edit');
        Route::post('/agency-employee/update/{id}', 'update')->name('agency-employee.update');
        Route::delete('/agency-employee/delete/{id}', 'destroy')->name('agency-employee.delete');
    });

    Route::controller(InstitutionController::class)->group(function () {
        Route::get('/all-institution', 'index')->name('institution.index');
        Route::get('/institution/create', 'create')->name('institution.create');
        Route::post('/institution/store', 'store')->name('institution.store');
    });

    Route::controller(InstitutionEmployController::class)->group(function () {
        Route::get('/institution-employees', 'index')->name('institution-employees.index');
        Route::get('/institution-employee/create', 'create')->name('institution-employee.create');
        Route::post('/institution-employee/store', 'store')->name('institution-employee.store');
        Route::get('/institution-employee/edit/{id}', 'edit')->name('institution-employee.edit');
        Route::post('/institution-employee/update/{id}', 'update')->name('institution-employee.update');
        Route::delete('/institution-employee/delete/{id}', 'destroy')->name('institution-employee.delete');
    });

    Route::controller(SpecialistController::class)->group(function () {
        Route::get('/all-specialist', 'specialistIndex')->name('specialist.index');
        Route::get('/specialist/create', 'specialistCreate')->name('specialist.create');
        Route::post('/specialist/store', 'specialistStore')->name('specialist.store');
    });

    Route::resource('/our-cores', OurCoreController::class);
    Route::resource('/foundation', FoundationController::class);
    Route::resource('/events', EventController::class);
    Route::resource('/contacts', ContactController::class);
    Route::get('/contacts/header/edit/{id}', [ContactController::class, 'contactEdit'])->name('contact.edit');
    Route::post('/contact/header/update/{id}', [ContactController::class, 'contactUpdate'])->name('contact.update');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/update/{id}', [BookingController::class, 'updateStatus'])->name('booking.update');

});

require __DIR__.'/settings.php';
