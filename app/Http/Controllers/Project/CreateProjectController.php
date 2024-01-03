<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Services\Project\CreateProject\CreateProjectServiceInterface;
use Illuminate\Http\Request;

class CreateProjectController extends Controller
{
    public function __invoke(CreateProjectRequest $request , CreateProjectServiceInterface $projectService)
    {
        return $projectService->create($request);
    }
}
