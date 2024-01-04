<?php

namespace App\Services\Project\DeleteProject;

use App\Http\Requests\Project\DeleteProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class DeleteProjectService implements DeleteProjectServiceInterface
{
    public function delete(DeleteProjectRequest $request, Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'massage' => 'project deleted',
        ]);
    }
}
