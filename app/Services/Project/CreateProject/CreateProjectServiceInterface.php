<?php

namespace App\Services\Project\CreateProject;

use App\Http\Requests\Project\CreateProjectRequest;

interface CreateProjectServiceInterface
{
    public function create(CreateProjectRequest $request);
}
