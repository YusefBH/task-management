<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\Http\Requests\Project\ShowProjectRequest;
use App\Http\Resources\Project\ProjectUsersResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowProjectService implements ShowProjectServiceInterface
{

    public function show(RequestShowProjectDTO $projectDTO): ProjectUsersResource
    {
        /** @var User $user */
        $user = Auth::user();
        return new ProjectUsersResource(
            $user->user_projects()
            ->where('project_id' , '=' , $projectDTO->project->id)
            ->first());
    }
}
