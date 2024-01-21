<?php

namespace App\DTO\Task\Request;

use App\Models\Task;

class RequestShowTaskDTO
{
    public function __construct(
        public readonly Task $task
    )
    {
    }

    public static function fromRequest(
        Task $task
    ): self
    {
        return new self(
            task: $task
        );
    }
}

