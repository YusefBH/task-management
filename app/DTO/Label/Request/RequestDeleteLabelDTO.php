<?php

namespace App\DTO\Label\Request;

use App\Models\Label;

class RequestDeleteLabelDTO
{
    public function __construct(
        public readonly Label $label,
    )
    {
    }

    public static function fromRequest(
        Label $label,
    ): self
    {
        return new self(
            label: $label
        );
    }
}

