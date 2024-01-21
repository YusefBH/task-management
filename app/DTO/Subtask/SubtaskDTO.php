<?php

namespace App\DTO\Subtask;

use App\DTO\ProjectUser\ProjectUserDTO;
use App\DTO\Task\TaskDTO;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SubtaskDTO
{
    public function __construct(
        public string         $id,
        public string         $name,
        public ?string        $description,
        public string         $deadline,
        public ProjectUserDTO $projectUserDTO,
        public TaskDTO        $taskDTO
    )
    {
    }

    public static function fromModel(Subtask $subtask): SubtaskDTO
    {

        $user = ProjectUser::find($subtask->project_user_id)->user_id;
        try {
            return new self(
                id: $subtask->id,
                name: $subtask->name,
                description: $subtask->description,
                deadline: $subtask->deadline,
                projectUserDTO: ProjectUserDTO::fromModel(User::find($user)),
                taskDTO: TaskDTO::fromModel($subtask->task)
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

