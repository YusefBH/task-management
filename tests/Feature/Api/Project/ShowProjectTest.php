<?php

namespace Tests\Feature\Api\Project;



use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_show_user_project_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $projects = Project::factory()
            ->count(30)
            ->create();

        foreach ($projects as $project) {
            if(rand(0,30)%3 == 0)
                ProjectUser::create([
                    'rule' => ProjectUser::RULE[rand(0 , count(ProjectUser::RULE)-1)],
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
        }
        ProjectUser::create([
            'rule' => ProjectUser::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $myproject = $user->getProjectsByRole(ProjectUser::RULE_OWNER)->first();

        $response = $this->actingAs($user)->getJson(route('project.show' , [
            'project' => $myproject->project_id
        ]));

        $response->assertOk();
        $response->assertJson([
            "rule" => ProjectUser::RULE_OWNER,
            "project" => [
                "id" => $myproject->project_id,
                "name"=> $myproject->project->name,
                "description" => $myproject->project->description
            ]
        ]);

    }

    public function test_show_user_project_when_unauthenticated(): void
    {
        $project = Project::factory()->createOne();
        $response= $this->getJson(route('project.show', [
            'project' => $project->id
        ]));

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);

    }

    public function test_show_another_user_project()
    {
        $user = User::factory()->createOne();
        $another_user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        ProjectUser::create([
            'rule' => ProjectUser::RULE_OWNER,
            'user_id' => $another_user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('project.show' , [
            'project' => $project->id
        ]));

        $response->assertStatus(403);
    }

    public function test_show_user_project_which_is_not_in_the_database()
    {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->getJson(route('project.show' , [
            'project' => 12
        ]));

        $response->assertStatus(404);
    }
}
