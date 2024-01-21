<?php

namespace App\DTO\Task\Request;

use App\Models\Project;

class RequestIndexTaskDTO
{
    public function __construct(
        public readonly Project $project,
        public readonly ?string $status
    )
    {
    }

    public static function fromRequest(
        Project $project,
        ?string $status
    ): self
    {
        return new self(
            project: $project,
            status: $status
        );
    }
}

