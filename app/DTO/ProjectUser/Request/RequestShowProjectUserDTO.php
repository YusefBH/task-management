<?php

namespace App\DTO\ProjectUser\Request;

use App\Models\Project;
use App\Models\User;

class RequestShowProjectUserDTO
{
    public function __construct(
        public readonly User    $user,
        public readonly Project $project,
    )
    {
    }

    public static function fromRequest(
        User    $user,
        Project $project,
    ): self
    {
        return new self(
            user: $user,
            project: $project
        );
    }
}

