<?php

namespace App\Services\Task\RemoveLabelTask;

use App\DTO\Task\Request\RequestRemoveLabelTaskDTO;
use App\DTO\Task\TaskDTO;

interface RemoveLabelTaskServiceInterface
{
    public function remove_label(RequestRemoveLabelTaskDTO $removeLabelTaskDTO):TaskDTO;
}
