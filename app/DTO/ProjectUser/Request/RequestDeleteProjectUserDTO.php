<?php

namespace App\DTO\ProjectUser\Request;

class RequestDeleteProjectUserDTO
{
    public function __construct(
        //public readonly string  $name,
    )
    {
    }

    public static function fromRequest(
        //string  $name,
    ): self
    {
        return new self(
            //name: $name
        );
    }
}

