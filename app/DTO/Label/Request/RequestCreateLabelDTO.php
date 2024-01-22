<?php

namespace App\DTO\Label\Request;

use App\Models\Project;

class RequestCreateLabelDTO
{
    public function __construct(
        public readonly string  $color,
        public readonly string  $title,
        public readonly Project $project,
    )
    {
    }

    public static function fromRequest(
        string  $color,
        ?string $title,
        Project $project
    ): self
    {
        return new self(
            color: $color,
            title: $title,
            project: $project
        );
    }
}

