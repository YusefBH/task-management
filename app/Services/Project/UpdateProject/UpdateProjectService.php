<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestUpdateProjectDTO;

class UpdateProjectService implements UpdateProjectServiceInterface
{

    public function update(RequestUpdateProjectDTO $projectDTO): ProjectDTO
    {
        $project = $projectDTO->project;
        $project->name = $projectDTO->name;
        $project->description = $projectDTO->description;

        $project->save();
        return ProjectDTO::fromModel(project: $project);
    }
}
