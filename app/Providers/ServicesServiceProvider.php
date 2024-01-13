<?php

namespace App\Providers;

use App\Services\Project\CreateProject\CreateProjectServiceConcrete;
use App\Services\Project\CreateProject\CreateProjectServiceInterface;
use App\Services\Project\DeleteProject\DeleteProjectServiceConcrete;
use App\Services\Project\DeleteProject\DeleteProjectServiceInterface;
use App\Services\Project\IndexProject\IndexProjectServiceConcrete;
use App\Services\Project\IndexProject\IndexProjectServiceInterface;
use App\Services\Project\ShowProject\ShowProjectServiceConcrete;
use App\Services\Project\ShowProject\ShowProjectServiceInterface;
use App\Services\Project\UpdateProject\UpdateProjectServiceConcrete;
use App\Services\Project\UpdateProject\UpdateProjectServiceInterface;
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
        $this->app->bind(
            CreateProjectServiceInterface::class,
            CreateProjectServiceConcrete::class
        );
        $this->app->bind(
            DeleteProjectServiceInterface::class,
            DeleteProjectServiceConcrete::class
        );
        $this->app->bind(
            IndexProjectServiceInterface::class,
           IndexProjectServiceConcrete::class
        );
        $this->app->bind(
            ShowProjectServiceInterface::class,
            ShowProjectServiceConcrete::class
        );
        $this->app->bind(
            UpdateProjectServiceInterface::class,
            UpdateProjectServiceConcrete::class
        );
    }
}
