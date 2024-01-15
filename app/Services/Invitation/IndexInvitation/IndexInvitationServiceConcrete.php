<?php

namespace App\Services\Invitation\IndexInvitation;

use App\DTO\Invitation\InvitationDTO;
use App\DTO\Invitation\Request\RequestIndexInvitationDTO;
use App\DTO\Pagination\Pagination;
use App\Enums\Role;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class IndexInvitationServiceConcrete implements IndexInvitationServiceInterface
{

    public function index(RequestIndexInvitationDTO $invitationDTO): Pagination
    {
        $pagination = Invitation::where('project_id', $invitationDTO->project->id)->paginate();

        $projects = $pagination->map(fn(Invitation $invitation) => InvitationDTO::fromModels(
            invitation: $invitation
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $projects->toArray()
        );
    }
}
