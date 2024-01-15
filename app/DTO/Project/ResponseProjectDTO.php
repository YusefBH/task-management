<?php

namespace App\DTO\Project;

use App\Models\Project;
use App\Models\ProjectUser;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResponseProjectDTO
{
    public function __construct(
        public string     $role,
        public ProjectDTO $project
    )
    {
    }

    public static function fromModels(ProjectUser $project_user, Project $project): ResponseProjectDTO
    {
        $projectDTO = ProjectDTO::fromModel($project);
        try {
            return new self(
                role: $project_user->role,
                project: $projectDTO
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

