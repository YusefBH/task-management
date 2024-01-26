<?php

namespace App\Services\Task\CreateTask;

use App\DTO\Task\Request\RequestCreateTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Exceptions\NotCreatedException;
use App\Models\Label;
use App\Models\Label_assign;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateTaskServiceConcrete implements CreateTaskServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateTaskDTO $taskDTO): TaskDTO
    {
        //todo: label in request gate
        DB::beginTransaction();
        try {
            $task = Task::create([
                'name' => $taskDTO->name,
                'status' => $taskDTO->status,
                'project_id' => $taskDTO->project->id,
            ]);
            if ($taskDTO->label) {
                Label_assign::create([
                    'label_id' => $taskDTO->label->id,
                    'foreign_type' => Task::class,
                    'foreign_id' => $task->id,
                ]);
            }
            DB::commit();
            return TaskDTO::fromModel(task: $task);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotCreatedException();
        }
    }
}
