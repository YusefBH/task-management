<?php

namespace App\Services\ProjectUser\ShowProjectUser;

use App\DTO\ProjectUser\Request\RequestShowProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;

interface ShowProjectUserServiceInterface
{
    public function show(RequestShowProjectUserDTO $projectUserDTO): ResponseProjectUserDTO;
}
