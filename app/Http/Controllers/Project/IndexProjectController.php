<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestIndexProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\IndexProjectRequest;
use App\Services\Project\IndexProject\IndexProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class IndexProjectController extends Controller
{
    public function __invoke(IndexProjectRequest $request, IndexProjectServiceInterface $projectService): JsonResponse
    {
        if ($request->has('role')) {
            $data = RequestIndexProjectDTO::fromRequest(
                $request->role
            );
        } else {
            $data = RequestIndexProjectDTO::fromRequest(
                null
            );
        }

        $responseData = $projectService->index($data);

        return Response::success($responseData);
    }
}
