<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestUpdateProjectDTO;

class UpdateProjectService implements UpdateProjectServiceInterface
{
    // todo: stay consistent with the interface
    public function update(RequestUpdateProjectDTO $projectDTO): ProjectDTO
    { // todo: add @property
        $project = $projectDTO->project;
        $project->name = $projectDTO->name;
        $project->description = $projectDTO->description;

        $project->save();
        return ProjectDTO::fromModel(project: $project);
    }
}
