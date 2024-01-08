<?php

namespace App\DTO\Project\Request;

use App\Models\Project;

class RequestShowProjectDTO
{ // todo: ctrl+alt+l
    public function __construct(
        public readonly Project $project
    ){}

    public static function fromRequest(
        Project $project
    ):self
    {
        return new self( // todo: specify the item you are filling for example project: $project
            $project
        );
    }
}

