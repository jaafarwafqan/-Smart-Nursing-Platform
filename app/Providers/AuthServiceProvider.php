<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Event;
use App\Models\Campaign;
use App\Models\researches;
use App\Models\User;

use App\Policies\EventPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\ResearchPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class    => EventPolicy::class,
        Campaign::class => CampaignPolicy::class,
        researches::class => ResearchPolicy::class,
        User::class     => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // يُعطي دور جميع الصلاحيات تلقائيًا
        Gate::before(fn ($user, $ability) => $user->hasRole(') ? true : null);
    }
}


