<?php

namespace App\DTO\User;

use App\Models\User;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserDTO
{
    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $email,
    )
    {
    }

    public static function fromModel(User $user): UserDTO
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
