<?php

namespace App\Policies;

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function IsThereSubtaskInTask(User $user, Task $task , Subtask $subtask): bool
    {
        return $task->subtasks()->pluck('id')->contains($subtask->id);
    }
}
