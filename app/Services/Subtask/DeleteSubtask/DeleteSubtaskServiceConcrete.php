<?php

namespace App\Services\Subtask\DeleteSubtask;

use App\DTO\Subtask\Request\RequestDeleteSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;
use App\Exceptions\NotDeletedException;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteSubtaskServiceConcrete implements DeleteSubtaskServiceInterface
{
    /**
     * @throws NotDeletedException
     */
    public function delete(RequestDeleteSubtaskDTO $subtaskDTO): SubtaskDTO
    {
        DB::beginTransaction();
        try {
            $subtask = $subtaskDTO->subtask;
            $subtask_label = $subtask->subtask_label;
            if ($subtask_label)
                $subtask_label->delete();
            $subtask->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotDeletedException();
        }

        return SubtaskDTO::fromModel($subtask);
    }
}
