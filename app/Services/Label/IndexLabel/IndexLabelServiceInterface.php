<?php

namespace App\Services\Label\IndexLabel;

use App\DTO\Label\Request\RequestIndexLabelDTO;
use App\DTO\Pagination\Pagination;

interface IndexLabelServiceInterface
{
    public function index(RequestIndexLabelDTO $labelDTO): Pagination;
}
