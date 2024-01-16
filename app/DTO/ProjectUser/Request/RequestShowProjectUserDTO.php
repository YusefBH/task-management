<?php

namespace App\DTO\ProjectUser\Request;

use App\Models\User;

class RequestShowProjectUserDTO
{
    public function __construct(
        public readonly User $user,
    )
    {
    }

    public static function fromRequest(
        User $user,
    ): self
    {
        return new self(
            user: $user
        );
    }
}

