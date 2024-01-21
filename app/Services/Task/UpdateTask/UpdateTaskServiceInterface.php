<?php

namespace App\Services\Task\UpdateTask;

use App\DTO\Task\Request\RequestUpdateTaskDTO;
use App\DTO\Task\TaskDTO;

interface UpdateTaskServiceInterface
{
    public function update(RequestUpdateTaskDTO $taskDTO): TaskDTO;
}
