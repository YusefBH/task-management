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
    // todo: use auto reformat (ctrl+alt+l) to make your code cleaner
    public function __invoke(IndexProjectRequest $request, IndexProjectServiceInterface $projectService) :JsonResponse
    {
        if ($request->has('rule')) {
            $data = RequestIndexProjectDTO::fromRequest(
                $request->rule // todo: add @property
            );
        } else {
            $data = RequestIndexProjectDTO::fromRequest(
                null
            );
        }

        $responseData = $projectService->index($data);

        return Response::success($responseData); // todo: add @property
    }
}
