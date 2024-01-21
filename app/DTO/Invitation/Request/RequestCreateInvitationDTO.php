<?php

namespace App\DTO\Invitation\Request;

use App\Models\Project;

class RequestCreateInvitationDTO
{
    public function __construct(
        public readonly string  $email,
        public readonly ?string $role,
        public readonly Project $project
    )
    {
    }

    public static function fromRequest(
        string  $email,
        ?string $role,
        Project $project
    ): self
    {
        return new self( // todo: put items in separate lines for better readability
            email: $email, role: $role, project: $project
        );
    }
}

