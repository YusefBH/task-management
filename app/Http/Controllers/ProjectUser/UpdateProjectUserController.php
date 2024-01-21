<?php

namespace App\Http\Controllers\ProjectUser;

use App\DTO\ProjectUser\Request\RequestUpdateProjectUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUser\UpdateProjectUserRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectUser\UpdateProjectUser\UpdateProjectUserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateProjectUserController extends Controller
{
    public function __invoke(UpdateProjectUserRequest          $request,
                             Project                           $project,
                             User                              $user,
                             UpdateProjectUserServiceInterface $updateProjectUserService): JsonResponse
    {
        $data = RequestUpdateProjectUserDTO::fromRequest(
            role: $request->role,
            user: $user,
            project: $project,
        );

        $responseData = $updateProjectUserService->show($data);

        return Response::success($responseData);
    }
}
