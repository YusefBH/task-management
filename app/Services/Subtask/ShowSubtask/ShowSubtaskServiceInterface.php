<?php

namespace App\Services\Subtask\ShowSubtask;

use App\DTO\Subtask\Request\RequestShowSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

interface ShowSubtaskServiceInterface
{
    public function show(RequestShowSubtaskDTO $subtaskDTO): SubtaskDTO;
}
