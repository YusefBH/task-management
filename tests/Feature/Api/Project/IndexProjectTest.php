<?php

namespace Tests\Feature\Api\Project;


use App\DTO\Pagination\Pagination;
use App\DTO\Project\ResponseProjectDTO;
use App\Enums\Rule;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @method assertJsonStructureExact(mixed $structure, mixed $responseDataItem)
 */
class IndexProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_all_user_projects_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $projects = Project::factory()
            ->count(100)
            ->create();

        foreach ($projects as $project) {
            if (rand(0, 30) % 3 == 0)
                ProjectUser::create([
                    'rule' => Rule::RULE[rand(0, count(Rule::RULE) - 1)],
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
        }

        $response = $this->actingAs($user)->call('GET', route('project.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'rule',
                    'project' => [
                        'id',
                        'name',
                        'description',
                    ],
                ],
            ],
            'meta',
        ]);
        /** @var User $user */
        $user_projects = $user->user_projects()->with('project')->paginate(5);
        $user_projects_dto = $user_projects
            ->map(fn(ProjectUser $projectuser) => ResponseProjectDTO::fromModels(project_user: $projectuser, project: $projectuser->project));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $user_projects, data: $user_projects_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_all_user_projects_when_unauthenticated(): void
    {
        $response = $this->getJson(route('project.index'));
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertUnauthorized();
    }

    public function test_return_user_projects_by_role(): void
    {
        $user = User::factory()->createOne();
        $projects = Project::factory()
            ->count(100)
            ->create();

        foreach ($projects as $project) {
            if (rand(0, 30) % 3 == 0)
                ProjectUser::create([
                    'rule' => Rule::RULE[rand(0, count(Rule::RULE) - 1)],
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
        }

        $rule = Rule::RULE[rand(0, count(Rule::RULE) - 1)];

        $response = $this->actingAs($user)->call('GET', route('project.index'), [
            'rule' => $rule,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'rule',
                    'project' => [
                        'id',
                        'name',
                        'description',
                    ],
                ],
            ],
            'meta',
        ]);

        $user_projects = $user->user_projects()->rule($rule)->with('project')->paginate(5);
        $user_projects_dto = $user_projects
            ->map(fn(ProjectUser $projectuser) => ResponseProjectDTO::fromModels(
                project_user: $projectuser,
                project: $projectuser->project
            ));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $user_projects, data: $user_projects_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_user_projects_for_users_who_do_not_have_a_project(): void
    {
        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->call('GET', route('project.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
            ]
        ]);
        $user_projects = $user->user_projects()->with('project')->paginate(5);
        $user_projects_dto = $user_projects
            ->map(fn(ProjectUser $projectuser) => ResponseProjectDTO::fromModels(project_user: $projectuser, project: $projectuser->project));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $user_projects, data: $user_projects_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }
}
