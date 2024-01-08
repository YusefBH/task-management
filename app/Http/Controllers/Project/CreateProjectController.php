<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Services\Project\CreateProject\CreateProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; // todo: remove unused imports
use Illuminate\Http\Response;

class CreateProjectController extends Controller
{
    public function __invoke(CreateProjectRequest $request , CreateProjectServiceInterface $projectService):JsonResponse
    {
        $data = RequestCreateProjectDTO::fromRequest( // todo: add @property
            $request->name,
            $request->description
        );
        $responsr_data =  $projectService->create($data); // todo: avoid misspelling

        return Response::success($responsr_data , 201); // todo: add @property
    }
}
