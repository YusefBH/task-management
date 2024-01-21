<?php

namespace App\Services\Project\DeleteProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestDeleteProjectDTO;

class DeleteProjectServiceConcrete implements DeleteProjectServiceInterface
{
    public function delete(RequestDeleteProjectDTO $projectDTO): ProjectDTO
    {
        $project = $projectDTO->project;
        $project->delete();

        return ProjectDTO::fromModel($project);
    }
}
