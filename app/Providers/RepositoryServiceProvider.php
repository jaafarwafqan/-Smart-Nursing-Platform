<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Contracts\CampaignServiceInterface::class  => \App\Services\CampaignService::class,
        \App\Contracts\EventServiceInterface::class     => \App\Services\EventService::class,
        \App\Contracts\ResearchServiceInterface::class  => \App\Services\ResearchService::class,
        \App\Contracts\UserServiceInterface::class      => \App\Services\UserService::class,
        \App\Contracts\TeacherServiceInterface::class   => \App\Services\TeacherService::class,
        \App\Contracts\StudentServiceInterface::class   => \App\Services\StudentService::class,
        \App\Contracts\ProfessorServiceInterface::class => \App\Services\ProfessorService::class,
        \App\Contracts\ProfessorResearchServiceInterface::class => \App\Services\ProfessorResearchService::class,
        \App\Contracts\JournalServiceInterface::class   => \App\Services\JournalService::class,
    ];
}
