<?php

namespace App\DTO\Subtask\Request;

use App\Models\Task;

class RequestIndexSubtaskDTO
{
    public function __construct(
        public readonly Task $task,
    )
    {
    }

    public static function fromRequest(
        Task $task,
    ): self
    {
        return new self(
            task: $task,
        );
    }
}

