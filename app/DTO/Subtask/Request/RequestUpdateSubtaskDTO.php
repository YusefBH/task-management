<?php

namespace App\DTO\Subtask\Request;

use App\Models\Label;
use App\Models\ProjectUser;
use App\Models\Subtask;

class RequestUpdateSubtaskDTO
{
    public function __construct(
        public readonly Subtask     $subtask,
        public readonly string      $name,
        public readonly ?string     $description,
        public readonly string      $deadline,
        public readonly ?Label      $label,
        public readonly ProjectUser $projectUser,
    )
    {
    }

    public static function fromRequest(
        Subtask     $subtask,
        string      $name,
        ?string     $description,
        string      $deadline,
        ?Label      $label,
        ProjectUser $projectUser,
    ): self
    {
        return new self(
            subtask: $subtask,
            name: $name,
            description: $description,
            deadline: $deadline,
            label: $label,
            projectUser: $projectUser,
        );
    }
}

