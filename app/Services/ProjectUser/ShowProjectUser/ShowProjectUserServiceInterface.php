<?php

namespace App\Services\ProjectUser\ShowProjectUser;

use App\DTO\ProjectUser\ProjectUserDTO;
use App\DTO\ProjectUser\Request\RequestShowProjectUserDTO;

interface ShowProjectUserServiceInterface
{
    public function show(RequestShowProjectUserDTO $projectUserDTO): ProjectUserDTO;
}
