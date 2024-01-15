<?php

namespace App\Services\Invitation\IndexInvitation;

use App\DTO\Invitation\Request\RequestIndexInvitationDTO;
use App\DTO\Pagination\Pagination;

interface IndexInvitationServiceInterface
{
    public function index(RequestIndexInvitationDTO $invitationDTO):Pagination;
}
