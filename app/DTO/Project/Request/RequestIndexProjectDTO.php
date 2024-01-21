<?php

namespace App\DTO\Project\Request;

class RequestIndexProjectDTO
{

    public function __construct(public readonly ?string $role)
        // todo: in our convention we put the constructor argument in a separate line (it is not crucial)
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

