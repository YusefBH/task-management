<?php

namespace App\Services\Invitation\CreateInvitation;

use App\DTO\Invitation\Request\RequestCreateInvitationDTO;
use App\DTO\Invitation\ResponseInvitationDTO;

interface CreateInvitationServiceInterface
{
    public function create(RequestCreateInvitationDTO $invitationDTO): ResponseInvitationDTO;
}
