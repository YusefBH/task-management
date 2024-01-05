<?php

namespace App\Services\Project\CreateProject;

use App\DTO\Project\Request\RequestCreateProjectDTO;
use App\DTO\Project\ResponseProjectDTO;
use App\Exceptions\NotCreatedException;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProjectService implements CreateProjectServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateProjectDTO $projectDTO)//: ResponseProjectDTO
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
                'user_id' =>5862,
                'project_id' => $project->id,
            ]);

            DB::commit();

            return ResponseProjectDTO::fromModels(project_user: $project_user , project: $project);
        }catch (Exception $exception){
            DB::rollBack();
            throw new NotCreatedException('project not created');
        }
    }
}
