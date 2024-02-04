<?php

namespace App\DTO\Subtask\Request;

use App\Models\Subtask;

class RequestRemoveLabelSubtaskDTO
{
    public function __construct(
        public readonly Subtask $subtask
    )
    {
    }

    public static function fromRequest(
        Subtask $subtask
    ): self
    {
        return new self(
            subtask: $subtask
        );
    }
}

