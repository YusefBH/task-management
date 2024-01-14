<?php

namespace App\Services\Project\CreateProject;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\DTO\Project\ResponseProjectDTO;
use App\Enums\Rule;
use App\Exceptions\NotCreatedException;
use App\Models\Project;
use App\Models\ProjectUser;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProjectServiceConcrete implements CreateProjectServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateProjectDTO $projectDTO): ResponseProjectDTO
    {

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $project = Project::create([
                'name' => $projectDTO->name,
                'description' => $projectDTO->description,
            ]);
            $project_user = ProjectUser::create([
                'rule' => Rule::RULE_OWNER,
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]); // todo: Use spatie permissions for project_user rule

            DB::commit();

            return ResponseProjectDTO::fromModels(project_user: $project_user, project: $project);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new NotCreatedException();
        }
    }
}
