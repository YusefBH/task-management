<?php

namespace App\Http\Controllers\Project;


use App\DTO\Project\Request\RequestUpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Project\UpdateProject\UpdateProjectServiceInterface;
use Illuminate\Http\Request;

class UpdateProjectController extends Controller
{
    public function __invoke(UpdateProjectRequest $request, Project $project, UpdateProjectServiceInterface $updateProjectService)
    {
        $data = RequestUpdateProjectDTO::fromRequest(
            project: $project , name: $request->name , description: $request->description
        );
        return $updateProjectService->update($data);
    }
}
