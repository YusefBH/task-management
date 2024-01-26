<?php

namespace App\DTO\Subtask\Request;

class RequestDeleteSubtaskDTO
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

