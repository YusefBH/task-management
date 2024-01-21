<?php

namespace App\Services\Task\IndexTask;


use App\DTO\Pagination\Pagination;
use App\DTO\Task\Request\RequestIndexTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Models\Task;

class IndexTaskServiceConcrete implements IndexTaskServiceInterface
{
    public function index(RequestIndexTaskDTO $taskDTO): Pagination
    {
        $pagination = $taskDTO->status
            ? $taskDTO->project->tasks()->status($taskDTO->status)->paginate(5)
            : $taskDTO->project->tasks()->paginate(5);
        $tasks = $pagination->map(fn(Task $task) => TaskDTO::fromModel(
            task: $task
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $tasks->toArray()
        );
    }
}
