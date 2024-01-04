<?php

namespace App\DTO\Project\Request;

use App\Models\Project;

class RequestDeleteProjectDTO
{
    public function __construct(
        public readonly Project $project,
    ){}

    public static function fromRequest(
        Project $project,
    ):self
    {
        return new self(
            $project
        );
    }
}

