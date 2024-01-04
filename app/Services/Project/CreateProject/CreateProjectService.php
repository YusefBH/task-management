<?php

namespace App\Services\Project\CreateProject;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\Http\Resources\Project\ProjectUsersResource;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateProjectService implements CreateProjectServiceInterface
{
    public function create(RequestCreateProjectDTO $projectDTO): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $project = Project::create([
                'name' => $projectDTO->name,
                'description' => $projectDTO->description,
            ]);
            $project_user = ProjectUser::create([
                'rule' => 'owner',
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
            $response = new ProjectUsersResource($project_user);
            DB::commit();
            return $response->response()->setStatusCode(201);
        }catch (Exception $exception){
            DB::rollBack();
            Log::error($exception);
            return response()->json([
                'massage' => 'project not created',
            ],500);
        }
    }
}
