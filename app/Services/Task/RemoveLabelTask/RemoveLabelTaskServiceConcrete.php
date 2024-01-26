<?php

namespace App\Services\Task\RemoveLabelTask;

use App\DTO\Task\Request\RequestRemoveLabelTaskDTO;
use App\DTO\Task\TaskDTO;

class RemoveLabelTaskServiceConcrete implements RemoveLabelTaskServiceInterface
{

    public function remove_label(RequestRemoveLabelTaskDTO $removeLabelTaskDTO): TaskDTO
    {
        $task_label = $removeLabelTaskDTO->task->task_label;
        if ($task_label)
            $task_label->delete();

        return TaskDTO::fromModel(task: $removeLabelTaskDTO->task);
    }
}
