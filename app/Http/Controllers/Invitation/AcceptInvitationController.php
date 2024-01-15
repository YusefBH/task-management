<?php

namespace App\Http\Controllers\Invitation;

use App\DTO\Invitation\Request\RequestAcceptInvitationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\AcceptInvitationRequest;
use App\Models\Invitation;
use App\Models\Project;
use App\Services\Invitation\AcceptInvitation\AcceptInvitationServiceInterface;
use Illuminate\Http\Response;

class AcceptInvitationController extends Controller
{
    public function __invoke(AcceptInvitationRequest          $request,
                             Project                          $project,
                             Invitation                       $invitation,
                             AcceptInvitationServiceInterface $acceptInvitationService)
    {
        $data = RequestAcceptInvitationDTO::fromRequest(
            invitation: $invitation
        );

        $response_data = $acceptInvitationService->accept($data);

        return Response::success($response_data, 200);
    }
}
