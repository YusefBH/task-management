<?php

namespace App\Services\Task\UpdateTask;

use App\DTO\Task\Request\RequestUpdateTaskDTO;
use App\DTO\Task\TaskDTO;

class UpdateTaskServiceConcrete implements UpdateTaskServiceInterface
{
    public function update(RequestUpdateTaskDTO $taskDTO): TaskDTO
    {
        $task = $taskDTO->task;
        $task->name = $taskDTO->name;
        $task->status = $taskDTO->status;
        //todo : label
        $task->save();

        return TaskDTO::fromModel(task: $task);
    }
}
