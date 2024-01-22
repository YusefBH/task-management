<?php

namespace App\Services\Label\DeleteLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestDeleteLabelDTO;

interface DeleteLabelServiceInterface
{
    public function delete(RequestDeleteLabelDTO $labelDTO): LabelDTO;
}
