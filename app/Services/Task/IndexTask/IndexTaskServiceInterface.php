<?php

namespace App\Services\Task\IndexTask;

use App\DTO\Pagination\Pagination;
use App\DTO\Task\Request\RequestIndexTaskDTO;

interface IndexTaskServiceInterface
{
    public function index(RequestIndexTaskDTO $taskDTO): Pagination;
}
