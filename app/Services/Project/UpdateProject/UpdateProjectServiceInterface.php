<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestUpdateProjectDTO;

interface UpdateProjectServiceInterface
{
    public function update(RequestUpdateProjectDTO $projectDTO):ProjectDTO;
}
