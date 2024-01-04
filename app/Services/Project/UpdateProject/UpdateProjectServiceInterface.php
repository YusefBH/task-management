<?php

namespace App\Services\Project\UpdateProject;

use App\DTO\Project\Request\RequestUpdateProjectDTO;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;

interface UpdateProjectServiceInterface
{
    public function update(RequestUpdateProjectDTO $request);
}
