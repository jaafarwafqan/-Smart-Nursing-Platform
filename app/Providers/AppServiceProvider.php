<?php

namespace App\Providers;

use App\Contracts\CampaignServiceInterface;
use App\Contracts\EventServiceInterface;
use App\Contracts\ResearchServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Services\CampaignService;
use App\Services\EventService;
use App\Services\ResearchService;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CampaignServiceInterface::class, CampaignService::class);
        $this->app->bind(EventServiceInterface::class, EventService::class);
        $this->app->bind(ResearchServiceInterface::class, ResearchService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
