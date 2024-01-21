<?php

namespace App\DTO\ProjectUser\Request;

use App\Models\Project;

class RequestIndexProjectUserDTO
{
    public function __construct(
        public readonly Project $project,
        public readonly ?string $role,
    )
    {
    }

    public static function fromRequest(
        Project $project,
        ?string $role,
    ): self
    {
        return new self(
            project: $project,
            role: $role,
        );
    }
}

