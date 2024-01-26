<?php

namespace App\DTO\Task\Request;

use App\Models\Label;
use App\Models\Project;

class RequestCreateTaskDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $status,
        public readonly Project $project,
        public readonly ?Label  $label,
    )
    {
    }

    public static function fromRequest(
        string  $name,
        ?string $status,
        Project $project,
        ?Label  $label,
    ): self
    {
        return new self(
            name: $name,
            status: $status,
            project: $project,
            label: $label,
        );
    }
}

