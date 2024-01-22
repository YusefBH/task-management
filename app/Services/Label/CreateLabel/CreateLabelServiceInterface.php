<?php

namespace App\Services\Label\CreateLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestCreateLabelDTO;

interface CreateLabelServiceInterface
{
    public function create(RequestCreateLabelDTO $labelDTO): LabelDTO;
}
