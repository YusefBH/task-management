<?php

namespace App\Services\Subtask\DeleteSubtask;

use App\DTO\Subtask\Request\RequestDeleteSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

interface DeleteSubtaskServiceInterface
{
    public function delete(RequestDeleteSubtaskDTO $subtaskDTO): SubtaskDTO;
}
