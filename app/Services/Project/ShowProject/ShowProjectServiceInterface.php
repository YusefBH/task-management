<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\Http\Requests\Project\ShowProjectRequest;
use App\Models\Project;

interface ShowProjectServiceInterface
{
    public function show(RequestShowProjectDTO $request);
}
