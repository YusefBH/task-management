<?php

namespace App\Services\Task\DeleteTask;

use App\DTO\Task\Request\RequestDeleteTaskDTO;
use App\DTO\Task\TaskDTO;

interface DeleteTaskServiceInterface
{
    public function delete(RequestDeleteTaskDTO $taskDTO): TaskDTO;
}
