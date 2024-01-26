<?php

namespace App\Services\Task\DeleteTask;

use App\DTO\Task\Request\RequestDeleteTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Exceptions\NotDeletedException;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteTaskServiceConcrete implements DeleteTaskServiceInterface
{
    /**
     * @throws NotDeletedException
     */
    public function delete(RequestDeleteTaskDTO $taskDTO): TaskDTO
    {
        DB::beginTransaction();
        try {
            $task = $taskDTO->task;
            $task_label = $task->task_label;
            if ($task_label)
                $task_label->delete();
            $task->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotDeletedException();
        }

        return TaskDTO::fromModel($task);
    }
}
