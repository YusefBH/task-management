<?php

namespace App\DTO\Subtask\Request;

use App\Models\Label;
use App\Models\ProjectUser;
use App\Models\Task;

class RequestCreateSubtaskDTO
{
    public function __construct(
        public readonly string      $name,
        public readonly ?string     $description,
        public readonly string      $deadline,
        public readonly Task        $task,
        public readonly ?Label      $label,
        public readonly ProjectUser $projectUser,
    )
    {
    }

    public static function fromRequest(
        string      $name,
        ?string     $description,
        string      $deadline,
        Task        $task,
        ?Label      $label,
        ProjectUser $projectUser,
    ): self
    {
        return new self(
            name: $name,
            description: $description,
            deadline: $deadline,
            task: $task,
            label: $label,
            projectUser: $projectUser
        );
    }
}

