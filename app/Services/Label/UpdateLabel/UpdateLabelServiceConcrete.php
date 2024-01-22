<?php

namespace App\Services\Label\UpdateLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestUpdateLabelDTO;

class UpdateLabelServiceConcrete implements UpdateLabelServiceInterface
{
    public function update(RequestUpdateLabelDTO $labelDTO): LabelDTO
    {
        $label = $labelDTO->label;
        $label->color = $labelDTO->color;
        $label->title = $labelDTO->title;
        $label->save();

        return LabelDTO::fromModel(label: $label);
    }
}
