<?php

namespace App\DTO\ProjectUser;

use App\Models\ProjectUser;
use App\Models\User;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResponseProjectUserDTO
{
    public function __construct(
        public string         $role,
        public ProjectUserDTO $user
    )
    {
    }

    public static function fromModels(ProjectUser $project_user, User $user): ResponseProjectUserDTO
    {
        $userDTO = ProjectUserDTO::fromModel($user);
        try {
            return new self(
                role: $project_user->role,
                user: $userDTO
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

