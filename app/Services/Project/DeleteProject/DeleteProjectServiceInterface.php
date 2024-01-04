<?php

namespace App\Services\Project\DeleteProject;

use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;

interface DeleteProjectServiceInterface
{
    public function delete(DeleteProjectRequest $request , Project $project);
}
