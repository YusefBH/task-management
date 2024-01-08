<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\Request\RequestUpdateProjectDTO;
use App\Http\Requests\Project\UpdateProjectRequest; // todo: remove unused imports
use App\Models\Project; // todo: remove unused imports

interface UpdateProjectServiceInterface
{
    public function update(RequestUpdateProjectDTO $request);
}
