<?php

namespace App\Http\Controllers\Project;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ShowProjectRequest;
use App\Models\Project;
use App\Services\Project\ShowProject\ShowProjectServiceInterface;
use Illuminate\Http\Response;

class ShowProjectController extends Controller
{
    public function __invoke(ShowProjectRequest $request , Project $project , ShowProjectServiceInterface $showProjectService)
    {
        $data = RequestShowProjectDTO::fromRequest($project);
        $rasponse_data =  $showProjectService->show($data);

        return Response::success($rasponse_data);
    }
}
