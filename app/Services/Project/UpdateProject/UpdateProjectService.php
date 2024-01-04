<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\Request\RequestUpdateProjectDTO;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class UpdateProjectService implements UpdateProjectServiceInterface
{

    public function update(RequestUpdateProjectDTO $projectDTO): JsonResponse
    {
        $project = $projectDTO->project;
        $project->name = $projectDTO->name;
        $project->description = $projectDTO->description;

        $project->save();
        $response =  new ProjectResource($project);
        return $response->response()->setStatusCode(200);
    }
}
