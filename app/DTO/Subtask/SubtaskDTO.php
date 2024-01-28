<?php

namespace App\DTO\Subtask;

use App\DTO\Label\LabelDTO;
use App\DTO\ProjectUser\ProjectUserDTO;
use App\DTO\Task\TaskDTO;
use App\Models\Label;
use App\Models\ProjectUser;
use App\Models\Subtask;
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
        public ProjectUserDTO $user,
        public TaskDTO        $task,
        public ?LabelDTO      $label,
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
                user: ProjectUserDTO::fromModel(User::find($user)),
                task: TaskDTO::fromModel($subtask->task),
                label: $subtask->subtask_label ? LabelDTO::fromModel(label: $subtask->subtask_label->label) : null,
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

