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
    // todo: delete unused element | specify the return type
    public function __invoke(ShowProjectRequest $request , Project $project , ShowProjectServiceInterface $showProjectService)
    {
        $data = RequestShowProjectDTO::fromRequest($project);
        $rasponse_data =  $showProjectService->show($data); // todo: avoid misspelling

        return Response::success($rasponse_data); // todo: add @property
    }
}
