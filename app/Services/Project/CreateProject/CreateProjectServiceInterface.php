<?php

namespace App\Services\Project\CreateProject;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\DTO\Project\ResponseProjectDTO;

interface CreateProjectServiceInterface
{
    public function create(RequestCreateProjectDTO $projectDTO):ResponseProjectDTO;
}
