<?php

namespace App\Services\Task\CreateTask;

use App\DTO\Task\Request\RequestCreateTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Exceptions\NotCreatedException;
use App\Models\Task;
use Exception;

class CreateTaskServiceConcrete implements CreateTaskServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateTaskDTO $taskDTO): TaskDTO
    {
        try {
            $task = Task::create([
                'name' => $taskDTO->name,
                'status' => $taskDTO->status,
                'project_id' => $taskDTO->project->id,
                //todo:: label in create task
            ]);
            return TaskDTO::fromModel(task: $task);
        } catch (Exception $exception) {
            throw new NotCreatedException();
        }
    }
}
