<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Services\Project\CreateProject\CreateProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateProjectController extends Controller
{
    public function __invoke(CreateProjectRequest $request , CreateProjectServiceInterface $projectService):JsonResponse
    {
        $data = RequestCreateProjectDTO::fromRequest(
            $request->name,
            $request->description
        );
        $responsr_data =  $projectService->create($data);

        return Response::success($responsr_data , 201);
    }
}
