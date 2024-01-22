<?php

namespace App\DTO\Label\Request;

use App\Models\Project;

class RequestIndexLabelDTO
{
    public function __construct(
        public readonly Project $project,
    )
    {
    }

    public static function fromRequest(
        Project $project,
    ): self
    {
        return new self(
            project: $project,
        );
    }
}

