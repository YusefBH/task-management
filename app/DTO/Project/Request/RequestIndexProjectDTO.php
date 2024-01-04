<?php

namespace App\DTO\Project\Request;

use Illuminate\Support\Arr;

class RequestIndexProjectDTO
{

    public function __construct(public readonly ?string $rule)
    {
    }

    public static function fromRequest(
        ?string $rule
    ):self
    {
        return new self(
          rule : $rule
        );
    }
}

