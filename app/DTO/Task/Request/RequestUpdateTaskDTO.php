<?php

namespace App\DTO\Task\Request;

use App\Models\Task;

class RequestUpdateTaskDTO
{
    public function __construct(
        public readonly Task $task,
        public readonly string  $name,
        public readonly string $status,
        //todo : label
    )
    {
    }

    public static function fromRequest(
        Task $task,
        string  $name,
        string $status
    ): self
    {
        return new self(
            task: $task,
            name: $name,
            status: $status
        );
    }
}

