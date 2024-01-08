<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\Http\Requests\Project\ShowProjectRequest; // todo: remove unused imports
use App\Models\Project;

interface ShowProjectServiceInterface
{
    public function show(RequestShowProjectDTO $request);
}
