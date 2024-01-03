<?php

namespace App\Services\Project\IndexProject;

use App\Http\Requests\Project\IndexProjectRequest;
use App\Http\Resources\Project\ProjectUsersResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IndexProjectService implements IndexProjectServiceInterface
{

    public function index(IndexProjectRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $projects = $request->has('rule')
            ? $user->getProjectsByRole($request->input('rule'))->paginate(5)
            : $user->user_projects()->paginate(5);
        $response = ProjectUsersResource::collection($projects);

        return $response->response()->setStatusCode(200);
    }
}
