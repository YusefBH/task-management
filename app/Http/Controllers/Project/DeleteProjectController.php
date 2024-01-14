<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestDeleteProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;
use App\Services\Project\DeleteProject\DeleteProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteProjectController extends Controller
{
    public function __invoke(DeleteProjectRequest $request, Project $project, DeleteProjectServiceInterface $deleteProjectService): JsonResponse
    {
        $data = RequestDeleteProjectDTO::fromRequest(
            project: $project
        );
        $responseData = $deleteProjectService->delete($data);
        return Response::success($responseData);
    }
}
