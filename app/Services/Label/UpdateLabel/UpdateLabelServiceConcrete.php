<?php

namespace App\Services;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestUpdateLabelDTO;
use App\Services\Label\UpdateLabel\UpdateLabelServiceInterface;

class UpdateLabelServiceConcrete implements UpdateLabelServiceInterface
{
    public function update(RequestUpdateLabelDTO $labelDTO): LabelDTO
    {
        dd();
    }
}
