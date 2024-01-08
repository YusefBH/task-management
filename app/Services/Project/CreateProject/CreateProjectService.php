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
// todo: better to use concrete in the end of service name for better readability
class CreateProjectService implements CreateProjectServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateProjectDTO $projectDTO)//: ResponseProjectDTO // todo: :(
    {
        /** @var User $user */
        $user = Auth::user(); // todo: delete unused variable

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
            ]); // todo: Use spatie permissions for project_user rule

            DB::commit();

            return ResponseProjectDTO::fromModels(project_user: $project_user , project: $project);
        }catch (Exception $exception){
            DB::rollBack();
            throw new NotCreatedException('project not created');
            // todo: messages can be localized (its not necessary)
        }
    }
}
