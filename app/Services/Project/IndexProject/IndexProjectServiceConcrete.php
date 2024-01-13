<?php /** @noinspection ALL */

namespace App\Services\Project\IndexProject;

use App\DTO\Pagination\Pagination;
use App\DTO\Project\Request\RequestIndexProjectDTO;
use App\DTO\Project\ResponseProjectDTO;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IndexProjectServiceConcrete implements IndexProjectServiceInterface
{

    public function index(RequestIndexProjectDTO $requestDTO): Pagination
    {
        /** @var User $user */
        $user = Auth::user();
        $pagination = $requestDTO->rule
            ? $user->user_projects()
                ->rule($requestDTO->rule)
                ->with('project')
                ->paginate(5)
            : $user->user_projects()
                ->with('project')
                ->paginate(5);
        $projects = $pagination->map(fn(ProjectUser $projectuser) => ResponseProjectDTO::fromModels(
            project_user: $projectuser,
            project: $projectuser->project
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $projects->toArray()
        );
    }
}
