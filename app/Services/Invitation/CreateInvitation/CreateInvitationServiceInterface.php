<?php

namespace App\Services\Invitation\CreateInvitation;

use App\DTO\Invitation\InvitationDTO;
use App\DTO\Invitation\Request\RequestCreateInvitationDTO;

interface CreateInvitationServiceInterface
{
    public function create(RequestCreateInvitationDTO $invitationDTO): InvitationDTO;
}
