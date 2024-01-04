<?php

namespace App\Services\Project\UpdateProject;

use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;

interface UpdateProjectServiceInterface
{
    public function update(UpdateProjectRequest $request , Project $project);
}
