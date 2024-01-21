<?php

namespace App\DTO\Project\Request;

use App\Models\Project;

class RequestUpdateProjectDTO
{
    public function __construct(
        public readonly Project $project,
        public readonly string  $name,
        public readonly ?string $description
    )
    {
    }

    public static function fromRequest(
        Project $project,
        string  $name,
        ?string $description
    ): self
    {
        return new self(
            project: $project,
            name: $name,
            description: $description
        );
    }
}

