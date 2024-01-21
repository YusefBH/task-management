<?php

namespace App\Services\Subtask\CreateSubtask;

use App\DTO\Subtask\Request\RequestCreateSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

interface CreateSubtaskServiceInterface
{
    public function create(RequestCreateSubtaskDTO $subtaskDTO): SubtaskDTO;
}
