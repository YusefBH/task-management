<?php

namespace App\Services\Project\DeleteProject;

use App\DTO\Project\ProjectDTO;
use App\DTO\Project\Request\RequestDeleteProjectDTO;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class DeleteProjectService implements DeleteProjectServiceInterface
{
    public function delete(RequestDeleteProjectDTO $projectDTO): ProjectDTO
    {
        $project = $projectDTO->project;
        $project->delete();

        return ProjectDTO::fromModel($project);
    }
}
