<?php

namespace App\Services\Label\ShowLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestShowLabelDTO;

class ShowLabelServiceConcrete implements ShowLabelServiceInterface
{
    public function show(RequestShowLabelDTO $labelDTO): LabelDTO
    {
        dd();
    }
}
