<?php

namespace App\Providers;

use App\Services\Invitation\AcceptInvitation\AcceptInvitationServiceConcrete;
use App\Services\Invitation\AcceptInvitation\AcceptInvitationServiceInterface;
use App\Services\Invitation\CreateInvitation\CreateInvitationServiceConcrete;
use App\Services\Invitation\CreateInvitation\CreateInvitationServiceInterface;
use App\Services\Invitation\IndexInvitation\IndexInvitationServiceConcrete;
use App\Services\Invitation\IndexInvitation\IndexInvitationServiceInterface;
use App\Services\Label\CreateLabel\CreateLabelServiceConcrete;
use App\Services\Label\CreateLabel\CreateLabelServiceInterface;
use App\Services\Label\DeleteLabel\DeleteLabelServiceConcrete;
use App\Services\Label\DeleteLabel\DeleteLabelServiceInterface;
use App\Services\Label\IndexLabel\IndexLabelServiceConcrete;
use App\Services\Label\IndexLabel\IndexLabelServiceInterface;
use App\Services\Label\ShowLabel\ShowLabelServiceConcrete;
use App\Services\Label\ShowLabel\ShowLabelServiceInterface;
use App\Services\Label\UpdateLabel\UpdateLabelServiceConcrete;
use App\Services\Label\UpdateLabel\UpdateLabelServiceInterface;
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
use App\Services\ProjectUser\DeleteProjectUser\DeleteProjectUserServiceConcrete;
use App\Services\ProjectUser\DeleteProjectUser\DeleteProjectUserServiceInterface;
use App\Services\ProjectUser\IndexProjectUser\IndexProjectUserServiceConcrete;
use App\Services\ProjectUser\IndexProjectUser\IndexProjectUserServiceInterface;
use App\Services\ProjectUser\ShowProjectUser\ShowProjectUserServiceConcrete;
use App\Services\ProjectUser\ShowProjectUser\ShowProjectUserServiceInterface;
use App\Services\ProjectUser\UpdateProjectUser\UpdateProjectUserServiceConcrete;
use App\Services\ProjectUser\UpdateProjectUser\UpdateProjectUserServiceInterface;
use App\Services\Subtask\CreateSubtask\CreateSubtaskServiceConcrete;
use App\Services\Subtask\CreateSubtask\CreateSubtaskServiceInterface;
use App\Services\Subtask\DeleteSubtask\DeleteSubtaskServiceConcrete;
use App\Services\Subtask\DeleteSubtask\DeleteSubtaskServiceInterface;
use App\Services\Subtask\IndexSubtask\IndexSubtaskServiceConcrete;
use App\Services\Subtask\IndexSubtask\IndexSubtaskServiceInterface;
use App\Services\Subtask\RemoveLabelSubtask\RemoveLabelSubtaskServiceConcrete;
use App\Services\Subtask\RemoveLabelSubtask\RemoveLabelSubtaskServiceInterface;
use App\Services\Subtask\ShowSubtask\ShowSubtaskServiceConcrete;
use App\Services\Subtask\ShowSubtask\ShowSubtaskServiceInterface;
use App\Services\Subtask\UpdateSubtask\UpdateSubtaskServiceConcrete;
use App\Services\Subtask\UpdateSubtask\UpdateSubtaskServiceInterface;
use App\Services\Task\CreateTask\CreateTaskServiceConcrete;
use App\Services\Task\CreateTask\CreateTaskServiceInterface;
use App\Services\Task\DeleteTask\DeleteTaskServiceConcrete;
use App\Services\Task\DeleteTask\DeleteTaskServiceInterface;
use App\Services\Task\IndexTask\IndexTaskServiceConcrete;
use App\Services\Task\IndexTask\IndexTaskServiceInterface;
use App\Services\Task\RemoveLabelTask\RemoveLabelTaskServiceConcrete;
use App\Services\Task\RemoveLabelTask\RemoveLabelTaskServiceInterface;
use App\Services\Task\ShowTask\ShowTaskServiceConcrete;
use App\Services\Task\ShowTask\ShowTaskServiceInterface;
use App\Services\Task\UpdateTask\UpdateTaskServiceConcrete;
use App\Services\Task\UpdateTask\UpdateTaskServiceInterface;
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
        ///////////////////////////////////////////////////////////////////////////////////////
        $this->app->bind(
            CreateInvitationServiceInterface::class,
            CreateInvitationServiceConcrete::class
        );
        $this->app->bind(
            AcceptInvitationServiceInterface::class,
            AcceptInvitationServiceConcrete::class
        );
        $this->app->bind(
            IndexInvitationServiceInterface::class,
            IndexInvitationServiceConcrete::class
        );
        ///////////////////////////////////////////////////////////////////////////////////////
        $this->app->bind(
            DeleteProjectUserServiceInterface::class,
            DeleteProjectUserServiceConcrete::class
        );
        $this->app->bind(
            IndexProjectUserServiceInterface::class,
            IndexProjectUserServiceConcrete::class
        );
        $this->app->bind(
            ShowProjectUserServiceInterface::class,
            ShowProjectUserServiceConcrete::class
        );
        $this->app->bind(
            UpdateProjectUserServiceInterface::class,
            UpdateProjectUserServiceConcrete::class
        );
        ///////////////////////////////////////////////////////////////////////////////////////
        $this->app->bind(
            IndexTaskServiceInterface::class,
            IndexTaskServiceConcrete::class
        );

        $this->app->bind(
            CreateTaskServiceInterface::class,
            CreateTaskServiceConcrete::class
        );

        $this->app->bind(
            ShowTaskServiceInterface::class,
            ShowTaskServiceConcrete::class
        );

        $this->app->bind(
            UpdateTaskServiceInterface::class,
            UpdateTaskServiceConcrete::class
        );

        $this->app->bind(
            DeleteTaskServiceInterface::class,
            DeleteTaskServiceConcrete::class
        );

        $this->app->bind(
            RemoveLabelTaskServiceInterface::class,
            RemoveLabelTaskServiceConcrete::class
        );
        ///////////////////////////////////////////////////////////////////////////////////////
        $this->app->bind(
            IndexLabelServiceInterface::class,
            IndexLabelServiceConcrete::class
        );

        $this->app->bind(
            CreateLabelServiceInterface::class,
            CreateLabelServiceConcrete::class
        );

        $this->app->bind(
            ShowLabelServiceInterface::class,
            ShowLabelServiceConcrete::class
        );

        $this->app->bind(
            UpdateLabelServiceInterface::class,
            UpdateLabelServiceConcrete::class
        );

        $this->app->bind(
            DeleteLabelServiceInterface::class,
            DeleteLabelServiceConcrete::class
        );
        ///////////////////////////////////////////////////////////////////////////////////////
        $this->app->bind(
            CreateSubtaskServiceInterface::class,
            CreateSubtaskServiceConcrete::class
        );
        $this->app->bind(
            DeleteSubtaskServiceInterface::class,
            DeleteSubtaskServiceConcrete::class
        );
        $this->app->bind(
            IndexSubtaskServiceInterface::class,
            IndexSubtaskServiceConcrete::class
        );
        $this->app->bind(
            ShowSubtaskServiceInterface::class,
            ShowSubtaskServiceConcrete::class
        );
        $this->app->bind(
            UpdateSubtaskServiceInterface::class,
            UpdateSubtaskServiceConcrete::class
        );

        $this->app->bind(
            RemoveLabelSubtaskServiceInterface::class,
            RemoveLabelSubtaskServiceConcrete::class
        );
    }
}
