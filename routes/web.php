<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfessorResearchController;
use App\Http\Controllers\JournalController;

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

// مسارات لوحة التحكم
Route::middleware(['auth', 'user.type:admin,supervisor'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/statistical', [DashboardController::class, 'statistical'])->name('dashboard.statistical');
    Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
    Route::get('/researches', [DashboardController::class, 'researches'])->name('dashboard.researches');
    Route::get('/students', [DashboardController::class, 'students'])->name('dashboard.students');
    Route::get('/professors', [DashboardController::class, 'professors'])->name('dashboard.professors');
    Route::get('/journals', [DashboardController::class, 'journals'])->name('dashboard.journals');
});

/* 🔒 Routes محمية */
Route::middleware(['auth'])->group(function () {
    // مسارات المستخدمين (للمدير فقط)
    Route::middleware(['user.type:admin', 'permission:manage_users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('users/{user}/attachments', [UserController::class, 'attachments'])->name('users.attachments');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    });

    // مسارات الفعاليات
    Route::middleware(['permission:manage_events'])->group(function () {
        Route::resource('events', EventController::class);
        Route::get('events/{event}/attachments', [EventController::class, 'attachments'])->name('events.attachments');
        Route::get('events/export', [EventController::class, 'export'])->name('events.export');
    });

    // مسارات الحملات
    Route::middleware(['permission:manage_campaigns'])->group(function () {
        Route::resource('campaigns', CampaignController::class);
        Route::get('campaigns/{campaign}/attachments', [CampaignController::class, 'attachments'])->name('campaigns.attachments');
        Route::get('campaigns/export', [CampaignController::class, 'export'])->name('campaigns.export');
    });

    // مسارات الأبحاث
    Route::middleware(['permission:manage_researches'])->group(function () {
        Route::resource('researches', ResearchController::class);
        Route::get('researches/{research}/download', [ResearchController::class, 'download'])->name('researches.download');
        Route::get('researches/export', [ResearchController::class, 'export'])->name('researches.export');
    });

    // مسارات الطلاب
    Route::prefix('students')->middleware(['permission:manage_students'])->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/', [StudentController::class, 'store'])->name('students.store');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::get('/import', [StudentController::class, 'importForm'])->name('students.import.form');
        Route::post('/import', [StudentController::class, 'import'])->name('students.import');
        Route::get('/export', [StudentController::class, 'export'])->name('students.export');
        Route::post('/{student}/attach-research', [StudentController::class, 'attachResearch'])->name('students.attachResearch');
    });

    // مسارات الأساتذة
    Route::prefix('professors')->middleware(['permission:manage_professors'])->group(function () {
        Route::get('/', [ProfessorController::class, 'index'])->name('professors.index');
        Route::get('/create', [ProfessorController::class, 'create'])->name('professors.create');
        Route::post('/', [ProfessorController::class, 'store'])->name('professors.store');
        Route::get('/{professor}/edit', [ProfessorController::class, 'edit'])->name('professors.edit');
        Route::put('/{professor}', [ProfessorController::class, 'update'])->name('professors.update');
        Route::delete('/{professor}', [ProfessorController::class, 'destroy'])->name('professors.destroy');
        Route::get('/import', [ProfessorController::class, 'importForm'])->name('professors.import.form');
        Route::post('/import', [ProfessorController::class, 'import'])->name('professors.import');
        Route::get('/export', [ProfessorController::class, 'export'])->name('professors.export');
        Route::post('/{professor}/attach-research', [ProfessorController::class, 'attachResearch'])->name('professors.attachResearch');
    });

    // مسارات بحوث الأساتذة
    Route::middleware(['permission:manage_researches'])->group(function () {
        Route::resource('professor-researches', ProfessorResearchController::class);
        Route::get('/professor-researches/export', [ProfessorResearchController::class, 'export'])->name('professor-researches.export');
    });

    // مسارات المجلات
    Route::middleware(['permission:manage_journals'])->group(function () {
        Route::resource('journals', JournalController::class);
        Route::get('/journals/export', [JournalController::class, 'export'])->name('journals.export');
    });

    // مسارات الملف الشخصي
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/pass', [UserController::class, 'changePassword'])->name('profile.changePassword');
});
