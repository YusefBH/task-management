<?php

namespace App\Services\ProjectUser\IndexProjectUser;

use App\DTO\Pagination\Pagination;
use App\DTO\ProjectUser\Request\RequestIndexProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;
use App\Models\ProjectUser;

class IndexProjectUserServiceConcrete implements IndexProjectUserServiceInterface
{

    public function index(RequestIndexProjectUserDTO $projectUserDTO): Pagination
    {
        $pagination = $projectUserDTO->role
            ? $projectUserDTO->project->project_users()
                ->role($projectUserDTO->role)
                ->with('user')
                ->paginate(5)
            : $projectUserDTO->project->project_users()
                ->with('user')
                ->paginate(5);
        $projects = $pagination->map(fn(ProjectUser $projectuser) => ResponseProjectUserDTO::fromModels(
            project_user: $projectuser,
            user: $projectuser->user
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $projects->toArray()
        );
    }
}
