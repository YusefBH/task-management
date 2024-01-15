<?php

namespace App\Services\Invitation\AcceptInvitation;

use App\DTO\Invitation\InvitationDTO;
use App\DTO\Invitation\Request\RequestAcceptInvitationDTO;

interface AcceptInvitationServiceInterface
{
    public function accept(RequestAcceptInvitationDTO $invitationDTO): InvitationDTO;
}
