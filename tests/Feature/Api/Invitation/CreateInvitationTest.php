<?php

namespace Tests\Feature\Api\Invitation;

use App\Enums\Role;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_invitation_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertJsonStructure([
            "email",
            "role",
            "project" => [
                "id",
                "name",
                "description"
            ]
        ]);
        $this->assertEquals(
            $role,
            $response->getOriginalContent()->role
        );
        $this->assertEquals(
            $email,
            $response->getOriginalContent()->email
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project->id
        );
        $this->assertDatabaseHas('invitations', [
            'email' => $email,
            'role' => $role,
            'project_id' => $project->id
        ]);

        $response->assertStatus(201);
    }

    public function test_create_invitation_when_unauthenticated(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_create_invitation_when_role_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $email = fake()->email();
        $role = null;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertInvalid(['role']);
        $response->assertStatus(422);
    }

    public function test_create_invitation_when_email_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $email = null;
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertInvalid(['email']);
        $response->assertStatus(422);
    }

    public function test_create_invitation_when_email_is_not_email(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $email = "fhjnbdhs";
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertInvalid(['email']);
        $response->assertStatus(422);
    }

    public function test_create_invitation_for_users_who_do_not_have_a_project(): void
    {
        $user = User::factory()->createOne();

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => '12'
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertNotFound();
    }

    public function test_create_for_another_user_invitation(): void
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertStatus(403);
    }

    public function test_create_invitation_by_owner_role(): void
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = Role::ROLE_OWNER;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('invitation.create', [
            'project' => $project->id
        ]), [
            'email' => $email,
            'role' => $role,
        ]);

        $response->assertStatus(403);
    }
}
