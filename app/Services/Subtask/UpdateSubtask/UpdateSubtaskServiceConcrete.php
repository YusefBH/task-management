<?php

namespace App\Services\Subtask\UpdateSubtask;

use App\DTO\Subtask\Request\RequestUpdateSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;
use App\Models\Label_assign;
use App\Models\Subtask;

class UpdateSubtaskServiceConcrete implements UpdateSubtaskServiceInterface
{
    public function update(RequestUpdateSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        $subtask = $subtaskDTO->subtask;
        $subtask->name = $subtaskDTO->name;
        $subtask->description = $subtaskDTO->description;
        $subtask->deadline = $subtaskDTO->deadline;
        $subtask->project_user_id = $subtaskDTO->projectUser->id;
        if ($subtaskDTO->label) {
            $subtask_label = $subtask->subtask_label;
            if ($subtask_label) {
                $subtask_label->label_id = $subtaskDTO->label->id;
                $subtask_label->save();
            } else {
                Label_assign::create([
                    'label_id' => $subtaskDTO->label->id,
                    'foreign_type' => Subtask::class,
                    'foreign_id' => $subtask->id,
                ]);
            }
        }
        $subtask->save();

        return SubtaskDTO::fromModel(subtask: $subtask);
    }
}
