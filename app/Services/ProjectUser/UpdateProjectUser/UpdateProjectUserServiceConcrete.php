<?php

namespace App\Services\ProjectUser\UpdateProjectUser;

use App\DTO\ProjectUser\Request\RequestUpdateProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;
use App\Models\ProjectUser;

class UpdateProjectUserServiceConcrete implements UpdateProjectUserServiceInterface
{
    public function show(RequestUpdateProjectUserDTO $projectUserDTO): ResponseProjectUserDTO
    {
        /** @var ProjectUser $project_user */
        $project_user = ProjectUser::all()->where('user_id', $projectUserDTO->user->id)
            ->where('project_id', $projectUserDTO->project->id)
            ->first();

        $project_user->role = $projectUserDTO->role;
        $project_user->save();

        return ResponseProjectUserDTO::fromModels(
            project_user: $project_user,
            user: $projectUserDTO->user,
        );
    }
}
