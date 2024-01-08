<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind( // todo: do not address services manually use CreateProjectServiceInterface::class instead
            'App\Services\Project\CreateProject\CreateProjectServiceInterface',
            'App\Services\Project\CreateProject\CreateProjectService'
        );
        $this->app->bind(
            'App\Services\Project\DeleteProject\DeleteProjectServiceInterface',
            'App\Services\Project\DeleteProject\DeleteProjectService'
        );
        $this->app->bind(
            'App\Services\Project\IndexProject\IndexProjectServiceInterface',
            'App\Services\Project\IndexProject\IndexProjectService'
        );
        $this->app->bind(
            'App\Services\Project\ShowProject\ShowProjectServiceInterface',
            'App\Services\Project\ShowProject\ShowProjectService'
        );
        $this->app->bind(
            'App\Services\Project\UpdateProject\UpdateProjectServiceInterface',
            'App\Services\Project\UpdateProject\UpdateProjectService'
        );
    }
}
