<?php

namespace App\Services\ProjectUser\ShowProjectUser;

use App\DTO\ProjectUser\Request\RequestShowProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;
use App\Models\ProjectUser;

class ShowProjectUserServiceConcrete implements ShowProjectUserServiceInterface
{
    public function show(RequestShowProjectUserDTO $projectUserDTO): ResponseProjectUserDTO
    {
        /** @var ProjectUser $project_user */
        $project_user = ProjectUser::all()->where('user_id', $projectUserDTO->user->id)
            ->where('project_id', $projectUserDTO->project->id)
            ->first();

        $project_user->delete();

        return ResponseProjectUserDTO::fromModels(
            project_user: $project_user,
            user: $projectUserDTO->user,
        );
    }
}
