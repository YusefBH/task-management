<?php

namespace Tests\Feature\Api\Project;

use App\Enums\Rule;
use App\Models\ProjectUser;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_project_when_authenticated(): void
    {
        $user = User::factory()->createOne();
        $name = fake()->name();
        $description = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.create'), [
            'name' => $name,
            'description' => $description
        ]);

        $response->assertJsonStructure([
            "rule",
            "project" => [
                "id",
                "name",
                "description"
            ]
        ]);
        $this->assertEquals(
            Rule::RULE_OWNER,
            $response->getOriginalContent()->rule
        );
        $this->assertEquals(
            $name,
            $response->getOriginalContent()->project->name
        );
        $this->assertEquals(
            $description,
            $response->getOriginalContent()->project->description
        );
        $this->assertDatabaseHas('projects', [
            'name' => $name,
            'description' => $description
        ]);
        $this->assertDatabaseHas('project_users', [
            'rule' => Rule::RULE_OWNER,
            'user_id' => $user->id,
            'project_id' => $response->getOriginalContent()->project->id
        ]);

        $response->assertStatus(201);
    }

    public function test_create_project_when_unauthenticated(): void{
        $name = fake()->name();
        $description = fake()->text();
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.create'), [
            'name' => $name,
            'description' => $description
        ]);
        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_create_project_when_name_is_null(): void{
        $user = User::factory()->createOne();
        $name = null;
        $description = fake()->text();
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('project.create'), [
            'name' => $name,
            'description' => $description
        ]);

        $response->assertInvalid(['name']);
        $response->assertStatus(422);
    }
}
