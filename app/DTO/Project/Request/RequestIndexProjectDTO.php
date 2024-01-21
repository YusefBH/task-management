<?php

namespace App\DTO\Project\Request;

class RequestIndexProjectDTO
{

    public function __construct(public readonly ?string $role)
    {
    }

    public static function fromRequest(
        ?string $role
    ): self
    {
        return new self(
            role: $role
        );
    }
}

