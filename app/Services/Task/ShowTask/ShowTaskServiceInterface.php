<?php

namespace App\Services\Task\ShowTask;

use App\DTO\Task\Request\RequestShowTaskDTO;
use App\DTO\Task\TaskDTO;

interface ShowTaskServiceInterface
{
    public function show(RequestShowTaskDTO $taskDTO): TaskDTO;
}
