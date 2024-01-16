<?php

namespace App\Services\ProjectUser\IndexProjectUser;

use App\DTO\Pagination\Pagination;
use App\DTO\ProjectUser\Request\RequestIndexProjectUserDTO;

interface IndexProjectUserServiceInterface
{
    public function index(RequestIndexProjectUserDTO $projectUserDTO):Pagination;
}
