<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Eloquent\TaskRepository;
use App\Policies\TaskPolicy;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(
        //     TaskRepositoryInterface::class,
        //     TaskRepository::class
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(Task::class, TaskPolicy::class);
    }
}
