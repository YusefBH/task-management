<?php

namespace App\Services\ProjectUser\DeleteProjectUser;

use App\DTO\ProjectUser\Request\RequestDeleteProjectUserDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;

interface DeleteProjectUserServiceInterface
{
    public function delete(RequestDeleteProjectUserDTO $projectUserDTO):ResponseProjectUserDTO;
}
