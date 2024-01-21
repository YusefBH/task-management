<?php

namespace App\Http\Controllers\ProjectUser;

use App\DTO\ProjectUser\Request\RequestDeleteProjectUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUser\DeleteProjectUserRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectUser\DeleteProjectUser\DeleteProjectUserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteProjectUserController extends Controller
{
    public function __invoke(DeleteProjectUserRequest          $request,
                             Project                           $project,
                             User                              $user,
                             DeleteProjectUserServiceInterface $deleteProjectUserService): JsonResponse
    {
        $data = RequestDeleteProjectUserDTO::fromRequest(
            user: $user,
            project: $project
        );

        $responseData = $deleteProjectUserService->delete($data);

        return Response::success($responseData);
    }
}
