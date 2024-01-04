<?php

namespace App\Services\Project\IndexProject;

use App\DTO\Project\Request\RequestIndexProjectDTO;
use App\Http\Requests\Project\IndexProjectRequest;
use App\Http\Resources\Project\ProjectUsersResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IndexProjectService implements IndexProjectServiceInterface
{

    public function index(RequestIndexProjectDTO $dto): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $projects = $dto->rule
            ? $user->getProjectsByRole($dto->rule)->paginate(5)
            : $user->user_projects()->paginate(5);
        $response = ProjectUsersResource::collection($projects);

        return $response->response()->setStatusCode(200);
    }
}
