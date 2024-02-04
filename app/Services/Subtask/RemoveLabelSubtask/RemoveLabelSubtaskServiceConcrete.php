<?php

namespace App\Services\Subtask\RemoveLabelSubtask;

use App\DTO\Subtask\Request\RequestRemoveLabelSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;

class RemoveLabelSubtaskServiceConcrete implements RemoveLabelSubtaskServiceInterface
{

    public function remove_label(RequestRemoveLabelSubtaskDTO $removeLabelSubtaskDTO): SubtaskDTO
    {
        $subtask_label = $removeLabelSubtaskDTO->subtask->subtask_label;
        if ($subtask_label)
            $subtask_label->delete();

        return SubtaskDTO::fromModel(subtask: $removeLabelSubtaskDTO->subtask);
    }
}
