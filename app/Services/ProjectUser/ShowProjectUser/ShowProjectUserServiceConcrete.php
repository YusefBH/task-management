<?php

namespace App\Services\ProjectUser\ShowProjectUser;

use App\DTO\ProjectUser\ProjectUserDTO;
use App\DTO\ProjectUser\Request\RequestShowProjectUserDTO;

class ShowProjectUserServiceConcrete implements ShowProjectUserServiceInterface
{
    public function show(RequestShowProjectUserDTO $projectUserDTO): ProjectUserDTO
    {
        return ProjectUserDTO::fromModel($projectUserDTO->user);
    }
}
