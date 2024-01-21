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
        return new self( // todo: put items in separate lines for better readability
            name: $name, description: $description
        );
    }
}

