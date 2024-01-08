<?php

namespace App\DTO\Project\Request;

use App\Models\Project;

class RequestDeleteProjectDTO
{ // todo: ctrl+alt+l
    public function __construct(
        public readonly Project $project,
    ){}
    // todo: name better be fromModel while you give a model as method's argument
    public static function fromRequest(
        Project $project,
    ):self
    {
        return new self( // todo: specify the item you are filling for example project: $project
            $project
        );
    }
}

