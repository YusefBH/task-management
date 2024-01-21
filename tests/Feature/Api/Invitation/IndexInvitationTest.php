<?php

namespace Tests\Feature\Api\Invitation;

use App\Enums\Role;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @method assertJsonStructureExact(mixed $structure, mixed $responseDataItem)
 */
class IndexInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_all_invitation_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $projects = Project::factory()
            ->count(10)
            ->create();

        foreach ($projects as $project) {
            if (rand(0, 30) % 3 == 0)
                ProjectUser::create([
                    'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
        }

        $projectuser = ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        Invitation::create([
            'email' => fake()->email(),
            'role' => Role::ROLE[rand(0, count(Role::ROLE) - 1)],
            'project_id' => $projectuser->project_id,
        ]);

        Invitation::factory()->count(50)->create();

        $response = $this->actingAs($user)->call('GET', route('invitation.index', [
            'project' => $projectuser->project->id
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'links',
            'data' => [
                '*' => [
                    'email',
                    'role',
                    'project' => [
                        'id',
                        'name',
                        'description',
                    ],
                ],
            ],
            'meta',
        ]);
    }

    public function test_return_all_invitation_when_unauthenticated(): void
    {
        $project = Project::factory()->createOne();
        $response = $this->getJson(route('invitation.index', [
            'project' => $project->id
        ]));
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertUnauthorized();
    }

    public function test_return_another_user_invitation(): void
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);
        Invitation::create([
            'role' => Role::ROLE_MEMBER,
            'email' => fake()->email(),
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('invitation.index', [
            'project' => $project->id
        ]));

        $response->assertStatus(403);
    }

    public function test_return_invitation_for_users_who_do_not_have_a_project(): void
    {
        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->getJson(route('invitation.index', [
            'project' => '12'
        ]));

        $response->assertNotFound();
    }

    public function test_return_invitation_for_users_who_do_not_have_a_invitation(): void
    {
        $user = User::factory()->createOne();

        $project = Project::factory()->createOne();

        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => Role::ROLE_OWNER
        ]);

        $response = $this->actingAs($user)->getJson(route('invitation.index', [
            'project' => $project->id
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
            ]
        ]);
    }
}
