<?php

namespace Tests\Feature\Api\Task;

use App\DTO\Label\LabelDTO;
use App\Enums\Role;
use App\Models\Label;
use App\Models\Label_assign;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_task_with_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
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

        $response = $this->actingAs($user)->getJson(route('project.task.show', [
            'project' => $project->id,
            'task' => $task->id
        ]));

        $response->assertOk();
        $response->assertJson([
            'id' => $task->id,
            'name' => $task->name,
            'status' => $task->status,
            'project_id' => $project->id,
            'label' => [
                'id' => $label->id,
                'title' => $label->title,
                'color' => $label->color,
                'project_id' => $label->project->id
            ]
        ]);
    }

    public function test_show_task_without_label_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.task.show', [
            'project' => $project->id,
            'task' => $task->id
        ]));

        $response->assertOk();
        $response->assertJson([
            'id' => $task->id,
            'name' => $task->name,
            'status' => $task->status,
            'project_id' => $project->id,
            'label' => null
        ]);
    }

    public function test_show_task_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $response = $this->getJson(route('project.task.show', [
            'project' => $project->id,
            'task' => $task->id
        ]));


        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_show_task_by_user_not_there_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);
        $response = $this->actingAs($user)->getJson(route('project.task.show', [
            'project' => $project->id,
            'task' => $task->id
        ]));
        $response->assertStatus(403);
    }

    public function test_show_task_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.task.show', [
            'project' => 12,
            'task' => $task->id
        ]));
        $response->assertNotFound();
    }

    public function test_show_task_for_when_task_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.task.show', [
            'project' => $project->id,
            'task' => 12
        ]));
        $response->assertNotFound();
    }
}
