<?php

namespace App\Services\Task\ShowTask;

use App\DTO\Task\Request\RequestShowTaskDTO;
use App\DTO\Task\TaskDTO;

class ShowTaskServiceConcrete implements ShowTaskServiceInterface
{
    public function show(RequestShowTaskDTO $taskDTO): TaskDTO
    {
        return TaskDTO::fromModel(task: $taskDTO->task);
    }
}
