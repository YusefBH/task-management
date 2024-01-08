<?php

namespace App\DTO\Project;

use App\Models\Project;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProjectDTO
{ // todo: ctrl+alt+l
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description
    ){}

    public static function fromModel(Project $project): ProjectDTO
    {
        try {
            return new self( // todo : add @property
                id: $project->id,
                name: $project->name,
                description: $project->description
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}
