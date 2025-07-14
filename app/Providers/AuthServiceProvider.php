<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskStatus;
use App\Policies\TaskStatusPolicy;
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        TaskStatus::class => TaskStatusPolicy::class,
        Task::class => TaskPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
