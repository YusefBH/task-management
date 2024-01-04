<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Services\Project\CreateProject\CreateProjectServiceInterface;
use Illuminate\Http\Request;

class CreateProjectController extends Controller
{
    public function __invoke(CreateProjectRequest $request , CreateProjectServiceInterface $projectService)
    {
        $data = RequestCreateProjectDTO::fromRequest(
            $request->name,
            $request->description
        );
        return $projectService->create($data);
    }
}
