<?php

namespace App\DTO\Subtask\Request;

use App\Models\Subtask;

class RequestDeleteSubtaskDTO
{
    public function __construct(
        public readonly Subtask $subtask
    )
    {
    }

    public static function fromRequest(
        Subtask $subtask,
    ): self
    {
        return new self(
            subtask: $subtask,
        );
    }
}

