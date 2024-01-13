<?php

namespace App\Services\Project\ShowProject;

use App\DTO\Project\Request\RequestShowProjectDTO;
use App\DTO\Project\ResponseProjectDTO;

interface ShowProjectServiceInterface
{
    public function show(RequestShowProjectDTO $projectDTO):ResponseProjectDTO;
}
