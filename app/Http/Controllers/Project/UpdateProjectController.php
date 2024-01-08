<?php

namespace App\Http\Controllers\Project;


use App\DTO\Project\Request\RequestUpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Project\UpdateProject\UpdateProjectServiceInterface;
use Illuminate\Http\Request; // todo: remove unused imports
use Illuminate\Http\Response;

class UpdateProjectController extends Controller
{
    // todo: specify the return type | do not cross the ide line
    public function __invoke(UpdateProjectRequest $request, Project $project, UpdateProjectServiceInterface $updateProjectService)
    {
        $data = RequestUpdateProjectDTO::fromRequest(
            project: $project , name: $request->name , description: $request->description // todo: add @property
        );
        $responseData =  $updateProjectService->update($data);

        return Response::success($responseData); // todo: add @property
    }
}
