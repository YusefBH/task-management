<?php

namespace Tests\Feature\Api\Task;

use App\DTO\Pagination\Pagination;
use App\DTO\Task\TaskDTO;
use App\Enums\Role;
use App\Enums\TaskStatus;
use App\Models\Label;
use App\Models\Label_assign;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_all_tasks_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        Label_assign::create([
            'label_id' => $label->id,
            'foreign_type' => Task::class,
            'foreign_id' => $task->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.task.index', [
            'project' => $project->id,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                    'project_id',
                    'label'
                ],
            ],
            'meta',
        ]);

        $my_tasks = $project->tasks()->paginate(5);
        $task_dto = $my_tasks
            ->map(fn(Task $task) => TaskDTO::fromModel(task: $task));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $my_tasks, data: $task_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_all_tasks_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        Label_assign::create([
            'label_id' => $label->id,
            'foreign_type' => Task::class,
            'foreign_id' => $task->id,
        ]);

        $response = $this->getJson(route('project.task.index', [
            'project' => $project->id,
        ]));

        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertUnauthorized();
    }

    public function test_return_tasks_for_user_not_there_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        Label_assign::create([
            'label_id' => $label->id,
            'foreign_type' => Task::class,
            'foreign_id' => $task->id,
        ]);
        $response = $this->actingAs($user)->getJson(route('project.task.index', [
            'project' => $project->id,
        ]));


        $response->assertStatus(403);
    }

    public function test_return_tasks_for_projects_that_do_not_have_task(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        Label_assign::create([
            'label_id' => $label->id,
            'foreign_type' => Task::class,
            'foreign_id' => $task->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.task.index', [
            'project' => $project->id,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
            ]
        ]);

        $my_tasks = $project->tasks()->paginate(5);
        $task_dto = $my_tasks
            ->map(fn(Task $task) => TaskDTO::fromModel(task: $task));
        $response_data = Pagination::fromModelPaginatorAndData(
            paginator: $my_tasks, data: $task_dto->toArray()
        );
        $this->assertEquals($response->getOriginalContent(), $response_data);
    }

    public function test_return_labels_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->getJson(route('project.task.index', [
            'project' => 12,
        ]));

        $response->assertNotFound();
    }
}
