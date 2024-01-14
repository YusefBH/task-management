<?php

namespace Tests\Feature\Api\Project;

use App\Enums\Rule;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_project_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $name = fake()->name();
        $description = fake()->text();
        $project_user = ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);


        $response = $this->actingAs($user)->put(route('project.update', ['project' => $project->id]), [
            'name' => $name,
            'description' => $description
        ]);


        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('project_users', 1);
        $this->assertDatabaseHas('projects', [
            'id' => $project_user->id,
            'name' => $name,
            'description' => $description,
        ]);
        $response->assertOk();
        $response->assertJson([
            'id' => $project_user->id,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function test_update_project_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $name = fake()->name();
        $description = fake()->text();
        ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);


        $response = $this->putJson(route('project.update', ['project' => $project->id]), [
            'name' => $name,
            'description' => $description
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_update_another_user_project(): void
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->putJson(route('project.update', [
            'project' => $project->id
        ]));

        $response->assertStatus(403);
    }

    public function test_update_user_project_which_is_not_in_the_database(): void
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->putJson(route('project.update', [
            'project' => 12
        ]));

        $response->assertStatus(404);
    }

    public function test_update_project_when_name_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
        $name = null;
        $description = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->put(route('project.update', ['project' => $project->id]), [
            'name' => $name,
            'description' => $description
        ]);

        $response->assertInvalid(['name']);
        $response->assertStatus(422);
    }
}
