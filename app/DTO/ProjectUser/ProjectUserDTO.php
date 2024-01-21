<?php

namespace App\DTO\ProjectUser;

use App\Models\User;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProjectUserDTO
{
    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $email,
    )
    {
    }

    public static function fromModel(User $user): ProjectUserDTO
    {
        try {
            return new self(
                id: $user->id,
                name: $user->name,
                email: $user->email
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

