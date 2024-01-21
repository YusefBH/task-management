<?php

namespace App\DTO\Invitation\Request;

use App\Models\Invitation;

class RequestAcceptInvitationDTO
{
    public function __construct(
        public readonly Invitation  $invitation,
    )
    {
    }

    public static function fromRequest(
        Invitation  $invitation,
    ): self
    {
        return new self(
            invitation: $invitation
        );
    }
}

