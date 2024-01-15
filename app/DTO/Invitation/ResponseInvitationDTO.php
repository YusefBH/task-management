<?php

namespace App\DTO\Invitation;

use App\DTO\Project\ProjectDTO;
use App\Models\Invitation;
use App\Models\Project;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResponseInvitationDTO
{
    public function __construct(
        public string $email,
        public string $role,
        public ProjectDTO $project
    )
    {
    }

    public static function fromModels(Invitation $invitation): ResponseInvitationDTO
    {
        $project = ProjectDTO::fromModel($invitation->project);
        try {
            return new self(
                email: $invitation->email,
                role: $invitation->role,
                project: $project
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

