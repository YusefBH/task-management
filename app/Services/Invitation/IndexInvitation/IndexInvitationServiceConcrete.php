<?php

namespace App\Services\Invitation\IndexInvitation;

use App\DTO\Invitation\Request\RequestIndexInvitationDTO;
use App\DTO\Invitation\ResponseInvitationDTO;
use App\DTO\Pagination\Pagination;
use App\Enums\Role;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class IndexInvitationServiceConcrete implements IndexInvitationServiceInterface
{

    public function index(RequestIndexInvitationDTO $invitationDTO): Pagination
    {
        $user = Auth::user();
        $projectsId = $user->user_projects()
            ->role(Role::ROLE_OWNER)
            ->pluck('project_id');

        $pagination = Invitation::whereIn('project_id', $projectsId)->paginate();

        $projects = $pagination->map(fn(Invitation $invitation) => ResponseInvitationDTO::fromModels(
            invitation: $invitation
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $projects->toArray()
        );
    }
}
