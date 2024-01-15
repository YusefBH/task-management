<?php

namespace App\Services\Invitation\AcceptInvitation;


use App\DTO\Invitation\Request\RequestAcceptInvitationDTO;
use App\DTO\Invitation\ResponseInvitationDTO;

interface AcceptInvitationServiceInterface
{
    public function accept(RequestAcceptInvitationDTO $invitationDTO): ResponseInvitationDTO;
}
