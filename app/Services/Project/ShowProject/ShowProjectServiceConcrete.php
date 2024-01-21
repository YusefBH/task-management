<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\DTO\Project\ResponseProjectDTO;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowProjectServiceConcrete implements ShowProjectServiceInterface
{
    public function show(RequestShowProjectDTO $projectDTO): ResponseProjectDTO
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var ProjectUser $project */
        $project = $user->user_projects()
            ->where('project_id', '=', $projectDTO->project->id)
            ->first();

        return ResponseProjectDTO::fromModels(project_user: $project, project: $project->project);
    }
}
