<?php

namespace App\Services\Subtask\UpdateSubtask;

use App\DTO\Subtask\Request\RequestUpdateSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

class UpdateSubtaskServiceConcrete implements UpdateSubtaskServiceInterface
{
    public function update(RequestUpdateSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        dd();
    }
}
