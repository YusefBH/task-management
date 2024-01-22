<?php

namespace App\Services\Label\ShowLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestShowLabelDTO;

interface ShowLabelServiceInterface
{
    public function show(RequestShowLabelDTO $labelDTO): LabelDTO;
}
