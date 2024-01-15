<?php

namespace App\Http\Controllers\Invitation;

use App\DTO\Invitation\Request\RequestIndexInvitationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\IndexInvitationRequest;
use App\Models\Project;
use App\Services\Invitation\IndexInvitation\IndexInvitationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexInvitationController extends Controller
{
    public function __invoke(IndexInvitationRequest $request, Project $project ,  IndexInvitationServiceInterface $indexInvitationService): JsonResponse
    {
        $data = RequestIndexInvitationDTO::fromRequest($project);

        $response_data = $indexInvitationService->index($data);

        return Response::success($response_data);
    }
}
