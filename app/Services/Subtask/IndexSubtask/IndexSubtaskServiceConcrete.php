<?php

namespace App\Services\Subtask\IndexSubtask;

use App\DTO\Pagination\Pagination;
use App\DTO\Subtask\Request\RequestIndexSubtaskDTO;

class IndexSubtaskServiceConcrete implements IndexSubtaskServiceInterface
{
    public function index(RequestIndexSubtaskDTO $subtaskDTO): Pagination
    {
        dd();
    }
}
