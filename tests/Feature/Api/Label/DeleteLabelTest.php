<?php

namespace Tests\Feature\Api\Label;

use App\Enums\Role;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_label_when_authenticated(): void
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

        $response = $this->actingAs($user)->deleteJson(route('project.label.delete', [
            'project' => $project->id,
            'label' => $label->id
        ]));

        $response->assertOk();
        $this->assertDatabaseCount('labels', 0);
        $response->assertJson([
            'id' => $label->id,
            'color' => $label->color,
            'title' => $label->title,
            'project_id' => $project->id,
        ]);
    }

    public function test_delete_label_when_unauthenticated(): void
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

        $response = $this->deleteJson(route('project.label.delete', [
            'project' => $project->id,
            'label' => $label->id
        ]));


        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_delete_label_by_user_not_there_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('project.label.delete', [
            'project' => $project->id,
            'label' => $label->id
        ]));
        $response->assertStatus(403);
    }

    public function test_delete_label_by_user_who_not_owner_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(1 , count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('project.label.delete', [
            'project' => $project->id,
            'label' => $label->id
        ]));
        $response->assertStatus(403);
    }

    public function test_delete_label_for_projects_that_do_not_exist(): void
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

        $response = $this->actingAs($user)->deleteJson(route('project.label.delete', [
            'project' => 12,
            'label' => $label->id
        ]));
        $response->assertNotFound();
    }

    public function test_delete_label_for_when_label_not_exist(): void
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

        $response = $this->actingAs($user)->deleteJson(route('project.label.delete', [
            'project' => $project->id,
            'label' => 12
        ]));
        $response->assertNotFound();
    }
}
