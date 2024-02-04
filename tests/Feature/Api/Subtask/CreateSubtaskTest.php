<?php

namespace Tests\Feature\Api\Subtask;

use App\Enums\Role;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSubtaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_subtask_with_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'deadline',
            "user" => [
                "id",
                "name",
                "email",
            ],
            "task" => [
                "id",
                "name",
                "status",
                "project_id",
                "label",
            ],
            'label' => [
                'id',
                'title',
                'color',
                'project_id'
            ],
        ]);
        $this->assertEquals(
            $name,
            $response->getOriginalContent()->name
        );
        $this->assertEquals(
            $description,
            $response->getOriginalContent()->description
        );
        $this->assertEquals(
            $deadline,
            $response->getOriginalContent()->deadline
        );
        $this->assertEquals(
            $task->id,
            $response->getOriginalContent()->task->id
        );
        $this->assertEquals(
            $label->id,
            $response->getOriginalContent()->label->id
        );
        $this->assertEquals(
            $user->id,
            $response->getOriginalContent()->user->id
        );
        $this->assertDatabaseHas('subtasks', [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'task_id' => $task->id
        ]);
        $this->assertDatabaseCount('label_assigns', 1);
    }

    public function test_create_subtask_without_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);


        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'deadline',
            "user" => [
                "id",
                "name",
                "email",
            ],
            "task" => [
                "id",
                "name",
                "status",
                "project_id",
                "label",
            ],
            'label',
        ]);
        $this->assertEquals(
            $name,
            $response->getOriginalContent()->name
        );
        $this->assertEquals(
            $description,
            $response->getOriginalContent()->description
        );
        $this->assertEquals(
            $deadline,
            $response->getOriginalContent()->deadline
        );
        $this->assertEquals(
            $task->id,
            $response->getOriginalContent()->task->id
        );
        $this->assertEquals(
            null,
            $response->getOriginalContent()->label
        );
        $this->assertEquals(
            $user->id,
            $response->getOriginalContent()->user->id
        );
        $this->assertDatabaseHas('subtasks', [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'task_id' => $task->id
        ]);
    }

    public function test_create_subtask_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_create_subtask_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => 12,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertNotFound();
    }

    public function test_create_subtask_for_tasks_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => 12
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertNotFound();
    }

    public function test_create_subtask_by_user_who_not_owner_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(1, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);


        $response->assertStatus(403);
    }

    public function test_create_subtask_when_name_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = null;
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['name']);
        $response->assertStatus(422);
    }

    public function test_create_subtask_when_description_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = null;
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['description']);
        $response->assertStatus(422);
    }

    public function test_create_subtask_when_deadline_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = null;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['deadline']);
        $response->assertStatus(422);
    }

    public function test_create_subtask_when_user_id_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => null,
            'label_id' => $label->id
        ]);
        $response->assertStatus(403);
    }

    public function test_create_subtask_when_deadline_is_invalid(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp - 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['deadline']);
        $response->assertStatus(422);
    }

    public function test_create_subtask_when_label_is_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => 12
        ]);

        $response->assertStatus(403);
    }

    public function test_create_subtask_when_label_is_belongs_to_another_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $project2 = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project2->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id
        ]);

        $name = fake()->name();
        $description = fake()->text();
        $deadline = Carbon::now()->timestamp + 100;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.subtask.create', [
            'project' => $project->id,
            'task' => $task->id
        ]), [
            'name' => $name,
            'description' => $description,
            'deadline' => $deadline,
            'user_id' => $user->id,
            'label_id' => $label->id
        ]);

        $response->assertStatus(403);
    }
}
