<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware تعمل مع كل طلب HTTP (عالميًا).
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\EncryptCookies::class,
    ];

    /**
     * مجموعات Middleware جاهزة ("web" و "api").
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * الوسطاء المسمّاة (تُستخدم في Route::middleware()).
     */
    protected $middlewareAliases = [
        /* --- Laravel Built‑ins --- */
        'auth'        => \App\Http\Middleware\Authenticate::class,
        'guest'       => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed'      => \App\Http\Middleware\ValidateSignature::class,
        'throttle'    => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'    => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        /* --- ✨ Spatie Permission Middleware --- */
        'role'                => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission'          => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission'  => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    ];

    /**
     * Load the application's command routes.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
