<?php

namespace App\Services\Label\DeleteLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestDeleteLabelDTO;

class DeleteLabelServiceConcrete implements DeleteLabelServiceInterface
{
    public function delete(RequestDeleteLabelDTO $labelDTO): LabelDTO
    {
        $label = $labelDTO->label;
        $label->delete();

        return LabelDTO::fromModel($label);
    }
}
