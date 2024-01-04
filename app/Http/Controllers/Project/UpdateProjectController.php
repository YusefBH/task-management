<?php

namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Project\UpdateProject\UpdateProjectServiceInterface;
use Illuminate\Http\Request;

class UpdateProjectController extends Controller
{
    public function __invoke(UpdateProjectRequest $request, Project $project, UpdateProjectServiceInterface $updateProjectService)
    {
        return $updateProjectService->update($request , $project);
    }
}
