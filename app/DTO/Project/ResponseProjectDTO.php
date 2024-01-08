<?php

namespace App\DTO\Project;

use App\Models\Project;
use App\Models\ProjectUser;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResponseProjectDTO
{ // todo: ctrl+alt+l
    public function __construct(
        public string $rule,
        public ProjectDTO $project
    ){}

    public static function fromModels(ProjectUser $project_user , Project $project): ResponseProjectDTO
    {
        $projectDTO = ProjectDTO::fromModel($project);
        try {
            return new self( // todo: add @property
                rule: $project_user->rule,
                project: $projectDTO
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

