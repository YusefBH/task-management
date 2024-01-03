<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\IndexProjectRequest;
use App\Services\Project\IndexProject\IndexProjectServiceInterface;
use Illuminate\Http\Request;

class IndexProjectController extends Controller
{
    public function __invoke(IndexProjectRequest $request  , IndexProjectServiceInterface $projectService)
    {
        return $projectService->index($request);
    }
}
