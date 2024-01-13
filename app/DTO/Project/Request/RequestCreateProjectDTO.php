<?php

namespace App\DTO\Project\Request;

class RequestCreateProjectDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly ?string $description
    )
    {
    }

    public static function fromRequest(
        string  $name,
        ?string $description
    ): self
    {
        return new self(
            name: $name, description: $description
        );
    }
}

