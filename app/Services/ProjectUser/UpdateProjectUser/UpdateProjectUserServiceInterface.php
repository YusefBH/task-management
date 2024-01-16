<?php

namespace App\Services\ProjectUser\UpdateProjectUser;

use App\DTO\ProjectUser\Request\RequestUpdateProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;

interface UpdateProjectUserServiceInterface
{
    public function show(RequestUpdateProjectUserDTO $projectUserDTO):ResponseProjectUserDTO;
}
