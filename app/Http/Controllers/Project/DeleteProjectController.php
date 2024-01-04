<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;
use App\Services\Project\DeleteProject\DeleteProjectServiceInterface;

class DeleteProjectController extends Controller
{
    public function __invoke(DeleteProjectRequest $request , Project $project , DeleteProjectServiceInterface $deleteProjectService)
    {
        return $deleteProjectService->delete($request , $project);
    }
}
