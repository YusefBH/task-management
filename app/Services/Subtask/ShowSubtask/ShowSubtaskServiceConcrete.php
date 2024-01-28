<?php

namespace App\Services\Subtask\ShowSubtask;

use App\DTO\Subtask\Request\RequestShowSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

class ShowSubtaskServiceConcrete implements ShowSubtaskServiceInterface
{
    public function show(RequestShowSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        return SubtaskDTO::fromModel(subtask: $subtaskDTO->subtask);
    }
}
