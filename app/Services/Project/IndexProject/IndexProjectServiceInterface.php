<?php

namespace App\Services\Project\IndexProject;

use App\DTO\Pagination\Pagination;
use App\DTO\Project\Request\RequestIndexProjectDTO;

interface IndexProjectServiceInterface
{
    public function index(RequestIndexProjectDTO $requestDTO):Pagination;
}
