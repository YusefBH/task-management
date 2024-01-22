<?php

namespace Tests\Feature\Api\Label;

use App\DTO\Label\LabelDTO;
use App\DTO\Pagination\Pagination;
use App\Enums\Role;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_all_labels_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        for ($i = 0; $i < 10; $i++) {
            if (rand(0, 30) % 2 == 0)
                Label::create([
                    'color' => '#123456',
                    'title' => fake()->title(),
                    'project_id' => $project->id,
                ]);
        }

        $response = $this->actingAs($user)->getJson(route('project.label.index', [
            'project' => $project->id,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'color',
                    'project_id',
                ],
            ],
            'meta',
        ]);

        $my_labels = $project->labels()->paginate(5);
        $labels_dto = $my_labels
            ->map(fn(Label $label) => LabelDTO::fromModel(label: $label));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $my_labels, data: $labels_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_all_labels_when_unauthenticated(): void
    {
        $project = Project::factory()->createOne();

        $response = $this->getJson(route('project.label.index',[
            'project' => $project,
        ]));
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertUnauthorized();
    }

    public function test_return_labels_for_user_not_there_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        for ($i = 0; $i < 10; $i++) {
            if (rand(0, 30) % 2 == 0)
                Label::create([
                    'color' => '#123456',
                    'title' => fake()->title(),
                    'project_id' => $project->id,
                ]);
        }

        $response = $this->actingAs($user)->getJson(route('project.label.index', [
            'project' => $project->id,
        ]));


        $response->assertStatus(403);
    }

    public function test_return_labels_for_projects_that_do_not_have_labels(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.label.index', [
            'project' => $project->id,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
            ]
        ]);

        $my_labels = $project->labels()->paginate(5);
        $labels_dto = $my_labels
            ->map(fn(Label $label) => LabelDTO::fromModel(label: $label));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $my_labels, data: $labels_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_labels_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->getJson(route('project.label.index', [
            'project' => 12,
        ]));

        $response->assertNotFound();
    }
}
