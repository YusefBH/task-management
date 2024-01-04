<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestIndexProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\IndexProjectRequest;
use App\Services\Project\IndexProject\IndexProjectServiceInterface;


class IndexProjectController extends Controller
{
    public function __invoke(IndexProjectRequest $request, IndexProjectServiceInterface $projectService)
    {
        if ($request->has('rule')) {
            $data = RequestIndexProjectDTO::fromRequest(
                $request->rule
            );
        } else {
            $data = RequestIndexProjectDTO::fromRequest(
                null
            );
        }

        return $projectService->index($data);
    }
}
