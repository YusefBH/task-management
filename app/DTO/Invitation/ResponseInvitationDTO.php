<?php

namespace App\DTO\Invitation;

use App\Models\Invitation;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResponseInvitationDTO
{
    public function __construct(
        public InvitationDTO $invitationDTO,
    )
    {
    }

    public static function fromModels(Invitation $invitation): ResponseInvitationDTO
    {
        try {
            return new self(
                invitationDTO: InvitationDTO::fromModels($invitation),
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

