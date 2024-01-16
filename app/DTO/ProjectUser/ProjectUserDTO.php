<?php

namespace App\DTO\ProjectUser;

use App\DTO\Project\ProjectDTO;
use App\Models\Project;
use App\Models\ProjectUser;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProjectUserDTO
{
    public function __construct(
/*        public string  $id,
        public string  $name,
        public ?string $description*/
    )
    {
    }

    public static function fromModel(Project $project): ProjectUserDTO
    {
        try {
            return new self(
/*                id: $project->id,
                name: $project->name,
                description: $project->description*/
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

