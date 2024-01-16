<?php

namespace App\Http\Controllers\ProjectUser;

use App\DTO\ProjectUser\Request\RequestShowProjectUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUser\ShowProjectUserRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectUser\ShowProjectUser\ShowProjectUserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowProjectUserController extends Controller
{
    public function __invoke(ShowProjectUserRequest          $request,
                             Project                         $project,
                             User                            $user,
                             ShowProjectUserServiceInterface $showProjectUserService): JsonResponse
    {
        $data = RequestShowProjectUserDTO::fromRequest(
            user: $user,
            project: $project,
        );

        $responseData = $showProjectUserService->show($data);

        return Response::success($responseData);
    }
}
