<?php

namespace App\Services\Project\ShowProject;

use App\Http\Requests\Project\ShowProjectRequest;
use App\Models\Project;

interface ShowProjectServiceInterface
{
    public function show(ShowProjectRequest $request , Project $project);
}
