<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\DTO\Project\Response\ResponseShowProjectDTO; // todo: remove unused imports
use App\DTO\Project\ResponseProjectDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowProjectService implements ShowProjectServiceInterface
{
    // todo: stay consistent with the interface
    public function show(RequestShowProjectDTO $projectDTO): ResponseProjectDTO
    {
        /** @var User $user */
        $user = Auth::user();

        $project = $user->user_projects()
            ->where('project_id' , '=' , $projectDTO->project->id)
            ->first();
        // todo: try to sort the arguments correctly
        return ResponseProjectDTO::fromModels(project: $project->project , project_user: $project);
    }
}
