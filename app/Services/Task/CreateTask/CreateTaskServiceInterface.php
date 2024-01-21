<?php

namespace App\Services\Task\CreateTask;

use App\DTO\Task\Request\RequestCreateTaskDTO;
use App\DTO\Task\TaskDTO;

interface CreateTaskServiceInterface
{
    public function create(RequestCreateTaskDTO $taskDTO): TaskDTO;
}
