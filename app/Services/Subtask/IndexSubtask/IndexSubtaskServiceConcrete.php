<?php

namespace App\Services\Subtask\IndexSubtask;

use App\DTO\Pagination\Pagination;
use App\DTO\Subtask\Request\RequestIndexSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;
use App\Models\Subtask;

class IndexSubtaskServiceConcrete implements IndexSubtaskServiceInterface
{
    public function index(RequestIndexSubtaskDTO $subtaskDTO): Pagination
    {

        $pagination = $subtaskDTO->task->subtasks()->paginate(5);
        $projects = $pagination->map(fn(Subtask $subtask) => SubtaskDTO::fromModel(
            subtask: $subtask
        ));
        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $projects->toArray()
        );
    }
}
