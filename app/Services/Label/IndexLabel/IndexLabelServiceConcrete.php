<?php

namespace App\Services\Label\IndexLabel;

use App\DTO\Label\Request\RequestIndexLabelDTO;
use App\DTO\Pagination\Pagination;

class IndexLabelServiceConcrete implements IndexLabelServiceInterface
{
    public function index(RequestIndexLabelDTO $labelDTO): Pagination
    {
        dd();
    }
}
