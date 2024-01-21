<?php

namespace Tests\Feature\Api\ProjectUser;


use App\DTO\Pagination\Pagination;
use App\DTO\Project\ResponseProjectDTO;
use App\DTO\ProjectUser\ResponseProjectUserDTO;
use App\Enums\Role;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @method assertJsonStructureExact(mixed $structure, mixed $responseDataItem)
 */
class IndexProjectUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_all_project_users_when_authenticated(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $memberUser = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $memberUser->id,
            'project_id' => $project->id,
        ]);

        $viewerUser = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_VIEWER,
            'user_id' => $viewerUser->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($ownerUser)->getJson(route('project.user.index', [
            'project' => $project->id
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'role',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ],
            'meta',
        ]);
        $project_users = $project->project_users()->with('user')->paginate(5);
        $user_projects_dto = $project_users
            ->map(fn(ProjectUser $projectuser) => ResponseProjectUserDTO::
            fromModels(project_user: $projectuser, user: $projectuser->user));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $project_users, data: $user_projects_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_all_project_users_when_unauthenticated(): void
    {
        $project = Project::factory()->createOne();
        $response = $this->getJson(route('project.user.index', [
            'project' => $project->id
        ]));
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertUnauthorized();
    }

    public function test_return_project_users_by_role(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $memberUser = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $memberUser->id,
            'project_id' => $project->id,
        ]);

        $viewerUser = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_VIEWER,
            'user_id' => $viewerUser->id,
            'project_id' => $project->id,
        ]);

        $role = Role::ROLE[rand(0, count(Role::ROLE) - 1)];
        $response = $this->actingAs($ownerUser)->getJson(route('project.user.index', [
            'project' => $project->id,
            'role' => $role,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'role',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ],
            'meta',
        ]);
        $project_users = $project->project_users()->role($role)->with('user')->paginate(5);
        $user_projects_dto = $project_users
            ->map(fn(ProjectUser $projectuser) => ResponseProjectUserDTO::
            fromModels(project_user: $projectuser, user: $projectuser->user));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $project_users, data: $user_projects_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_project_users_for_user_not_owner(): void
    {
        $user = User::factory()->createOne();

        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.user.index', [
            'project' => $project->id
        ]));

        $response->assertStatus(403);
    }

    public function test_return_project_users_for_users_who_do_not_have_a_project(): void
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->getJson(route('project.user.index', [
            'project' => 12
        ]));

        $response->assertNotFound();
    }
}
