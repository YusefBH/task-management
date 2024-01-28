<?php

namespace App\Services\Task\UpdateTask;

use App\DTO\Task\Request\RequestUpdateTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Models\Label_assign;
use App\Models\Task;

class UpdateTaskServiceConcrete implements UpdateTaskServiceInterface
{
    public function update(RequestUpdateTaskDTO $taskDTO): TaskDTO
    {
        $task = $taskDTO->task;
        $task->name = $taskDTO->name;
        $task->status = $taskDTO->status;
        if ($taskDTO->label) {
            $task_label = $task->task_label;
            if ($task_label) {
                $task_label->label_id = $taskDTO->label->id;
                $task_label->save();
            } else {
                Label_assign::create([
                    'label_id' => $taskDTO->label->id,
                    'foreign_type' => Task::class,
                    'foreign_id' => $task->id,
                ]);
            }
        }
        $task->save();

        return TaskDTO::fromModel(task: $task);
    }
}
