<?php

namespace App\Services\ProjectUser\DeleteProjectUser;

use App\DTO\ProjectUser\Request\RequestDeleteProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;
use App\Models\ProjectUser;

class DeleteProjectUserServiceConcrete implements DeleteProjectUserServiceInterface
{
    public function delete(RequestDeleteProjectUserDTO $projectUserDTO): ResponseProjectUserDTO
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
