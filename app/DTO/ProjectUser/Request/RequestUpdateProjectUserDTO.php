<?php

namespace App\DTO\ProjectUser\Request;

use App\Models\Project;
use App\Models\User;

class RequestUpdateProjectUserDTO
{
    public function __construct(
        public readonly string  $role,
        public readonly User    $user,
        public readonly Project $project,
    )
    {
    }

    public static function fromRequest(
        string  $role,
        User    $user,
        Project $project,
    ): self
    {
        return new self(
            role: $role,
            user: $user,
            project: $project
        );
    }
}

