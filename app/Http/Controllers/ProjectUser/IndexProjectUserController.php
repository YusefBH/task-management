<?php

namespace App\Http\Controllers\ProjectUser;

use App\DTO\ProjectUser\Request\RequestIndexProjectUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUser\IndexProjectUserRequest;
use App\Models\Project;
use App\Services\ProjectUser\IndexProjectUser\IndexProjectUserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexProjectUserController extends Controller
{
    public function __invoke(IndexProjectUserRequest          $request,
                             Project                          $project,
                             IndexProjectUserServiceInterface $projectUserService): JsonResponse
    {
        if ($request->has('role')) {
            $data = RequestIndexProjectUserDTO::fromRequest(
                project: $project,
                role: $request->role,
            );
        } else {
            $data = RequestIndexProjectUserDTO::fromRequest(
                project: $project,
                role: null,
            );
        }

        $responseData = $projectUserService->index($data);

        return Response::success($responseData);
    }
}
