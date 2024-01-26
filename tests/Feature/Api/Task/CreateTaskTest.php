<?php

namespace Tests\Feature\Api\Task;

use App\Enums\Role;
use App\Enums\TaskStatus;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_with_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'status',
            'project_id',
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
            $status,
            $response->getOriginalContent()->status
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project_id
        );
        $this->assertEquals(
            $label->id,
            $response->getOriginalContent()->label->id
        );
        $this->assertDatabaseHas('tasks', [
            'name' => $name,
            'status' => $status,
            'project_id' => $project->id
        ]);
        $this->assertDatabaseCount('label_assigns' , 1);
    }

    public function test_create_task_without_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'status',
            'project_id',
            'label',
        ]);
        $this->assertEquals(
            $name,
            $response->getOriginalContent()->name
        );
        $this->assertEquals(
            $status,
            $response->getOriginalContent()->status
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project_id
        );
        $this->assertEquals(
           null,
            $response->getOriginalContent()->label
        );
        $this->assertDatabaseHas('tasks', [
            'name' => $name,
            'status' => $status,
            'project_id' => $project->id
        ]);
    }

    public function test_create_task_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_create_task_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => 12
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertNotFound();
    }

    public function test_create_task_by_user_who_not_owner_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(1 , count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertStatus(403);
    }

    public function test_create_task_when_name_is_null(): void{
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = null;
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['name']);
        $response->assertStatus(422);
    }

    public function test_create_task_when_status_is_null(): void{
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = null;
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['status']);
        $response->assertStatus(422);
    }

    public function test_create_task_when_status_is_invalid(): void{
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::factory()->create([
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = 12;
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertInvalid(['status']);
        $response->assertStatus(422);
    }

    public function test_create_task_when_label_is_not_exist(): void{
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => 12
        ]);

        $response->assertStatus(403);
    }

    public function test_create_task_when_label_is_belongs_to_another_project(): void{
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

        $name = fake()->name();
        $status = TaskStatus::STATUS[rand(0, count(TaskStatus::STATUS) - 1)];
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.task.create', [
            'project' => $project->id
        ]), [
            'name' => $name,
            'status' => $status,
            'label_id' => $label->id
        ]);

        $response->assertStatus(403);
    }
}
