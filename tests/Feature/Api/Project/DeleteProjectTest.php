<?php

namespace Tests\Feature\Api\Project;

use App\Enums\Rule;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_delete_project_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $project_user = ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->delete(route('project.delete', ['project' => $project->id]));

        $this->assertDatabaseCount('projects', 0);
        $this->assertDatabaseCount('project_users', 0);
        $response->assertOk();
        $response->assertJson([
            'id' => $project_user->id,
            'name' => $project->name,
            'description' => $project->description
        ]);
    }

    public function test_delete_project_when_unauthenticated(): void
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


        $response = $this->deleteJson(route('project.delete', ['project' => $project->id]));

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_delete_another_user_project(): void
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'rule' => Rule::RULE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('project.delete', ['project' => $project->id]));

        $response->assertStatus(403);
    }

    public function test_delete_user_project_which_is_not_in_the_database(): void
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->deleteJson(route('project.delete', ['project' => 152]));

        $response->assertStatus(404);
    }
}
