<?php

namespace App\Services\Subtask\CreateSubtask;

use App\DTO\Subtask\Request\RequestCreateSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;
use App\Exceptions\NotCreatedException;
use App\Models\Label_assign;
use App\Models\Subtask;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateSubtaskServiceConcrete implements CreateSubtaskServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        DB::beginTransaction();
        try {
            $subtask = Subtask::create([
                'name' => $subtaskDTO->name,
                'description' => $subtaskDTO->description,
                'deadline' => $subtaskDTO->deadline,
                'project_user_id' => $subtaskDTO->projectUser->id,
                'task_id' => $subtaskDTO->task->id,
            ]);
            if ($subtaskDTO->label) {
                Label_assign::create([
                    'label_id' => $subtaskDTO->label->id,
                    'foreign_type' => Subtask::class,
                    'foreign_id' => $subtask->id,
                ]);
            }
            DB::commit();
            return SubtaskDTO::fromModel(subtask: $subtask);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotCreatedException();
        }
    }
}
