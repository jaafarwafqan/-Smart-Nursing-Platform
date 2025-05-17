<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Event;
use App\Models\Campaign;
use App\Models\Research;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Professor;
use App\Models\ProfessorResearch;
use App\Models\Journal;

use App\Policies\EventPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\ResearchPolicy;
use App\Policies\UserPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\StudentPolicy;
use App\Policies\ProfessorPolicy;
use App\Policies\ProfessorResearchPolicy;
use App\Policies\JournalPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Research::class => ResearchPolicy::class,
        Campaign::class   => CampaignPolicy::class,
        Event::class      => EventPolicy::class,
        Teacher::class    => TeacherPolicy::class,
        Student::class    => StudentPolicy::class,
        Professor::class  => ProfessorPolicy::class,
        ProfessorResearch::class => ProfessorResearchPolicy::class,
        Journal::class    => JournalPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // يُعطي دور جميع الصلاحيات تلقائيًا
        Gate::before(fn ($user, $ability) => $user->hasRole('admin') ? true : null);
    }
}


