<?php

namespace App\Services\Project\CreateProject;

use App\DTO\Project\Request\RequestCreateProjectDTO;

interface CreateProjectServiceInterface
{
    public function create(RequestCreateProjectDTO $request); // todo: specify return type
}
