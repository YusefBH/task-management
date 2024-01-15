<?php

namespace App\Services\Invitation\AcceptInvitation;

use App\DTO\Invitation\Request\RequestAcceptInvitationDTO;
use App\DTO\Invitation\ResponseInvitationDTO;
use App\Exceptions\Invitation\NotAcceptedException;
use App\Models\Invitation;
use App\Models\ProjectUser;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcceptInvitationServiceConcrete implements AcceptInvitationServiceInterface
{

    /**
     * @throws NotAcceptedException
     */
    public function accept(RequestAcceptInvitationDTO $invitationDTO): ResponseInvitationDTO
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            ProjectUser::create([
                'user_id' => $user->id,
                'project_id' => $invitationDTO->invitation->project->id,
                'role' => $invitationDTO->invitation->role
            ]);

            $invitationDTO->invitation->delete();
            DB::commit();
            return ResponseInvitationDTO::fromModels(invitation: $invitationDTO->invitation);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotAcceptedException();
        }
    }
}
