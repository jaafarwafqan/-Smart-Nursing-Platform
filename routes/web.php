<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Auth routes (no package)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // عرض نموذج الدخول
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    // محاولة الدخول
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
});

// تسجيل الخروج (يحتاج جلسة)
Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth')
    ->withoutMiddleware('guest'); // لا نحتاج إلى التحقق من الجلسة هنا
// عرض الصفحة الرئيسية بعد تسجيل الدخول

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

Route::view('/login', 'auth.login')->name('login');
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');

/* 🔒 Routes محمية */
Route::middleware('auth')->group(function () {

    Route::middleware('permission:manage_events')->resource('events', EventController::class);
    Route::get('events/{event}/attachments', [EventController::class, 'attachments'])
        ->name('events.attachments');
    // ✅ مسار التصدير
    Route::get('events/export', [EventController::class, 'export'])
        ->name('events.export');

    Route::middleware('permission:manage_campaigns')->resource('campaigns', CampaignController::class);
    Route::get('campaigns/{campaign}/attachments', [CampaignController::class, 'attachments'])
        ->name('campaigns.attachments');
    // ✅ مسار التصدير
    Route::get('campaigns/export', [CampaignController::class, 'export'])
        ->name('campaigns.export');


    Route::middleware('permission:manage_researches')->resource('researches', ResearchController::class);

    Route::middleware('permission:manage_users')->resource('users', UserController::class);


    Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

    // ✅ مسار التصدير
    Route::get('users/export', [UserController::class, 'export'])
        ->name('users.export');

});
