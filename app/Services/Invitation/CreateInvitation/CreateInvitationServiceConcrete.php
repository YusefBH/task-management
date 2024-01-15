<?php

namespace App\Services\Invitation\CreateInvitation;

use App\DTO\Invitation\Request\RequestCreateInvitationDTO;
use App\DTO\Invitation\ResponseInvitationDTO;
use App\Exceptions\InvitationErrorException;
use App\Mail\InviteUserToProject;
use App\Models\Invitation;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class CreateInvitationServiceConcrete implements CreateInvitationServiceInterface
{
    /**
     * @throws InvitationErrorException
     */
    public function create(RequestCreateInvitationDTO $invitationDTO): ResponseInvitationDTO
    {
        DB::beginTransaction();
        try {
            $invitation = Invitation::create([
                'email' => $invitationDTO->email,
                'role' => $invitationDTO->role,
                'project_id' => $invitationDTO->project->id,
            ]);

            $new_url = URL::temporarySignedRoute(
                'invitation.user.to.project',
                Carbon::now()->addDays(10),
                [
                    'project' => $invitation->id,
                    'hash' => sha1($invitationDTO->email . $invitationDTO->role),
                ]
            );

            Mail::to($invitationDTO->email)
                ->send(new InviteUserToProject($new_url, $invitationDTO));
            DB::commit();

            return ResponseInvitationDTO::fromModels(invitation: $invitation);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new InvitationErrorException($exception->getMessage());
        }
    }
}
