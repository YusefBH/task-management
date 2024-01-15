<?php

namespace App\DTO\Invitation\Request;

class RequestIndexInvitationDTO
{
    public function __construct()
    {
    }

    public static function fromRequest(): self
    {
        return new self();
    }
}

