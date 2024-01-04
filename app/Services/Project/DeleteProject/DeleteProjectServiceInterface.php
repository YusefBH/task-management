<?php

namespace App\Services\Project\DeleteProject;

use App\DTO\Project\Request\RequestDeleteProjectDTO;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;

interface DeleteProjectServiceInterface
{
    public function delete(RequestDeleteProjectDTO $request);
}
