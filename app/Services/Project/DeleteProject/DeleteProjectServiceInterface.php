<?php

namespace App\Services\Project\DeleteProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestDeleteProjectDTO;

interface DeleteProjectServiceInterface
{
    public function delete(RequestDeleteProjectDTO $projectDTO):ProjectDTO;
}
