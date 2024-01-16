<?php

namespace Tests\Feature\Api\Invitation;

use App\Enums\Role;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcceptInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_accept_invitation_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $invitation = Invitation::create([
            'email' => $email,
            'role' => $role,
            'project_id' => $projectuser->project_id,
        ]);

        $response = $this->actingAs($user)->getJson(route('invitation.user.to.project', [
            'project' => $project->id,
            'invitation' => $invitation->id,
            'hash' => sha1($email . $role)
        ]));


        $response->assertOk();
        $response->assertJson([
            "email" => $email,
            "role" => $role,
            "project" => [
                "id" => $project->id,
                "name" => $project->name,
                "description" => $project->description
            ]
        ]);

    }

    public function test_accept_invitation_when_unauthenticated(): void
    {
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $invitation = Invitation::create([
            'email' => $email,
            'role' => $role,
            'project_id' => $projectuser->project_id,
        ]);

        $response = $this->getJson(route('invitation.user.to.project', [
            'project' => $project->id,
            'invitation' => $invitation->id,
            'hash' => sha1($email . $role)
        ]));


        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);

    }

    public function test_accept_invitation_by_invalid_hash(): void
    {
        $user = User::factory()->createOne();
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $invitation = Invitation::create([
            'email' => $email,
            'role' => $role,
            'project_id' => $projectuser->project_id,
        ]);

        $response = $this->actingAs($user)->getJson(route('invitation.user.to.project', [
            'project' => $project->id,
            'invitation' => $invitation->id,
            'hash' => sha1("emailrole")
        ]));

        $response->assertStatus(403);
    }

    public function test_accept_when_invitation_dose_not_exist_in_database(): void
    {
        $user = User::factory()->createOne();
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();

        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;


        $response = $this->actingAs($user)->getJson(route('invitation.user.to.project', [
            'project' => $project->id,
            'invitation' => 12,
            'hash' => sha1($email . $role)
        ]));

        $response->assertNotFound();
    }

    public function test_accept_invitation_when_change_the_project_parameter_because_it_is_ineffective(): void
    {
        $user = User::factory()->createOne();
        $ownerUser = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $another_project = Project::factory()->createOne();
        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $ownerUser->id,
            'project_id' => $project->id,
        ]);

        $email = fake()->email();
        $role = rand() % 2 == 0 ? Role::ROLE_MEMBER : Role::ROLE_VIEWER;

        $invitation = Invitation::create([
            'email' => $email,
            'role' => $role,
            'project_id' => $projectuser->project_id,
        ]);

        $response = $this->actingAs($user)->getJson(route('invitation.user.to.project', [
            'project' => $another_project->id,
            'invitation' => $invitation->id,
            'hash' => sha1($email . $role)
        ]));


        $response->assertOk();
        $response->assertJson([
            "email" => $email,
            "role" => $role,
            "project" => [
                "id" => $project->id,
                "name" => $project->name,
                "description" => $project->description
            ]
        ]);

    }
}
