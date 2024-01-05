<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\DTO\Project\Response\ResponseShowProjectDTO;
use App\DTO\Project\ResponseProjectDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowProjectService implements ShowProjectServiceInterface
{

    public function show(RequestShowProjectDTO $projectDTO): ResponseProjectDTO
    {
        /** @var User $user */
        $user = Auth::user();

        $project = $user->user_projects()
            ->where('project_id' , '=' , $projectDTO->project->id)
            ->first();

        return ResponseProjectDTO::fromModels(project: $project->project , project_user: $project);
    }
}
