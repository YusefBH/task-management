<?php

namespace App\Services\Task\DeleteTask;

use App\DTO\Task\Request\RequestDeleteTaskDTO;
use App\DTO\Task\TaskDTO;

class DeleteTaskServiceConcrete implements DeleteTaskServiceInterface
{
    public function delete(RequestDeleteTaskDTO $taskDTO): TaskDTO
    {
        $task = $taskDTO->task;
        $task->delete();

        return TaskDTO::fromModel($task);
    }
}
