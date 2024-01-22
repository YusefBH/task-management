<?php

namespace App\DTO\Label\Request;


use App\Models\Label;

class RequestUpdateLabelDTO
{
    public function __construct(
        public readonly Label   $label,
        public readonly ?string $color,
        public readonly ?string $title,
    )
    {
    }

    public static function fromRequest(
        Label   $label,
        ?string $color,
        ?string $title,
    ): self
    {
        return new self(
            label: $label,
            color: $color,
            title: $title
        );
    }
}

