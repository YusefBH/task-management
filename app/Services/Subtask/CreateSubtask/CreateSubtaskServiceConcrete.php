<?php

namespace App\Services\Subtask\CreateSubtask;

use App\DTO\Subtask\Request\RequestCreateSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

class CreateSubtaskServiceConcrete implements CreateSubtaskServiceInterface
{
    public function create(RequestCreateSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        dd();
    }
}
