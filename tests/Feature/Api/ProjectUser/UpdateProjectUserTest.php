<?php

namespace Tests\Feature\Api\Project;

use App\Enums\Role;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProjectUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_project_users_when_authenticated(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $user->id
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertOk();
        $response->assertJson([
            "role" => Role::ROLE_VIEWER,
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email
            ]
        ]);

    }

    public function test_show_project_users_when_unauthenticated(): void
    {
        $project = Project::factory()->createOne();

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $user->id
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);

    }

    public function test_show_another_project_users_invalid_user(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $anotherUser = User::factory()->createOne();

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $anotherUser->id
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertStatus(403);
    }

    public function test_show_another_project_users_invalid_project(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $anotherProject = Project::factory()->createOne();

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $anotherProject->id,
            'user' => $user->id
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertStatus(403);
    }

    public function test_show_project_users_whose_user_is_not_in_the_database(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);


        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => 12
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertStatus(404);
    }

    public function test_show_project_users_whose_user_is_not_in_this_project(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $user->id
        ]), [
            'role' => Role::ROLE_VIEWER
        ]);

        $response->assertStatus(403);
    }

    public function test_update_project_when_role_is_null(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $user->id
        ]), [
            'role' => null
        ]);

        $response->assertInvalid(['role']);
        $response->assertStatus(422);
    }

    public function test_update_project_when_role_is_invalid(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $user = User::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_MEMBER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($ownerUser)->putJson(route('project.user.update', [
            'project' => $project->id,
            'user' => $user->id
        ]), [
            'role' => Role::ROLE_OWNER
        ]);

        $response->assertInvalid(['role']);
        $response->assertStatus(422);
    }
}
