<?php

namespace Tests\Feature\Api\Label;

use App\Enums\Role;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_label_when_authenticated(): void
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

        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertJsonStructure([
            'id',
            'title',
            'color',
            'project_id',

        ]);
        $this->assertEquals(
            $color,
            $response->getOriginalContent()->color
        );
        $this->assertEquals(
            $title,
            $response->getOriginalContent()->title
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project_id
        );
        $this->assertDatabaseHas('labels', [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(200);
    }

    public function test_update_project_when_unauthenticated(): void{

        $project = Project::factory()->createOne();
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_update_label_for_projects_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0,count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => 12,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertNotFound();
    }

    public function test_update_label_for_labels_that_for_another_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $project2 = Project::factory()->createOne();
        ProjectUser::create([
            'role' => Role::ROLE[rand(0,count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project2->id,
        ]);

        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(403);
    }

    public function test_update_label_for_labels_that_do_not_exist(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();

        ProjectUser::create([
            'role' => Role::ROLE[rand(0,count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);

        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => 12
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertNotFound();
    }

    public function test_update_label_by_user_who_not_owner_in_project(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        ProjectUser::create([
            'role' => Role::ROLE[rand(1 , count(Role::ROLE)-1)],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $color = '#' . rand(100000, 999999);
        $title = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(403);
    }

    public function test_update_label_when_color_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $color = null;
        $title = fake()->title();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'title',
            'color',
            'project_id',

        ]);
        $this->assertEquals(
            $color,
            $response->getOriginalContent()->color
        );
        $this->assertEquals(
            $title,
            $response->getOriginalContent()->title
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project_id
        );
        $this->assertDatabaseHas('labels', [
            'color' => $color,
            'title' => $title
        ]);


    }

    public function test_update_label_when_title_is_null(): void
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
        $color = '#'."145236";
        $title = null;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'title',
            'color',
            'project_id',

        ]);
        $this->assertEquals(
            $color,
            $response->getOriginalContent()->color
        );
        $this->assertEquals(
            $title,
            $response->getOriginalContent()->title
        );
        $this->assertEquals(
            $project->id,
            $response->getOriginalContent()->project_id
        );
        $this->assertDatabaseHas('labels', [
            'color' => $color,
            'title' => $title
        ]);


    }

    public function test_update_label_when_color_and_title_is_null(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $color = null;
        $title = null;
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(422);
    }

    public function test_update_label_when_value_is_not_unique(): void
    {
        $user = User::factory()->createOne();
        $project = Project::factory()->createOne();
        $label = Label::create([
            'color' => '#123456',
            'title' => fake()->title(),
            'project_id' => $project->id,
        ]);
        ProjectUser::create([
            'role' => Role::ROLE_OWNER,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        $color = '#' . rand(100000, 999999);
        $title = fake()->title();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->putJson(route('project.label.update', [
            'project' => $project->id,
            'label' => $label->id
        ]), [
            'color' => $color,
            'title' => $title
        ]);

        $response->assertStatus(422);
    }

}
