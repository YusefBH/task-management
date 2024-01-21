<?php

namespace App\DTO\Invitation\Request;

use App\Models\Project;

class RequestIndexInvitationDTO
{
    public function __construct(
        public readonly Project $project
    )
    {
    }

    public static function fromRequest(
        Project $project
    ): self
    {
        return new self(
            project: $project
        );
    }
}

