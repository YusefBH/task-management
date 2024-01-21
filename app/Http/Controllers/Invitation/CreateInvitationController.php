<?php

namespace App\Http\Controllers\Invitation;

use App\DTO\Invitation\Request\RequestCreateInvitationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\CreateInvitationRequest;
use App\Models\Project;
use App\Services\Invitation\CreateInvitation\CreateInvitationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateInvitationController extends Controller
{
    public function __invoke(CreateInvitationRequest          $request,
                             Project                          $project,
                             CreateInvitationServiceInterface $createInvitationService): JsonResponse
    {
        $data = RequestCreateInvitationDTO::fromRequest(
            email: $request->email,
            role: $request->role,
            project: $project,
        );
        $response_data = $createInvitationService->create($data);

        return Response::success($response_data, 201);
    }
}
