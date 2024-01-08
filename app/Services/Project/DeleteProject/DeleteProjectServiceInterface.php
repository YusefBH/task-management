<?php

namespace App\Services\Project\DeleteProject;

use App\DTO\Project\Request\RequestDeleteProjectDTO;
use App\Http\Requests\Project\DeleteProjectRequest; // todo: remove unused imports
use App\Models\Project;

interface DeleteProjectServiceInterface
{
    public function delete(RequestDeleteProjectDTO $request); // todo: specify return type
}
