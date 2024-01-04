<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestDeleteProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;
use App\Services\Project\DeleteProject\DeleteProjectServiceInterface;

class DeleteProjectController extends Controller
{
    public function __invoke(DeleteProjectRequest $request , Project $project , DeleteProjectServiceInterface $deleteProjectService)
    {
        $data = RequestDeleteProjectDTO::fromRequest(
            project: $project
        );
        return $deleteProjectService->delete($data);
    }
}
