<?php

namespace App\Services\Label\UpdateLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestUpdateLabelDTO;

interface UpdateLabelServiceInterface
{
    public function update(RequestUpdateLabelDTO $labelDTO): LabelDTO;
}
