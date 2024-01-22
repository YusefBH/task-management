<?php

namespace App\Services\Label\CreateLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestCreateLabelDTO;

class CreateLabelServiceConcrete implements CreateLabelServiceInterface
{
    public function create(RequestCreateLabelDTO $labelDTO): LabelDTO
    {
        dd();
    }
}
