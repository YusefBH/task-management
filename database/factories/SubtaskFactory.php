<?php

namespace Database\Factories;

use App\Models\ProjectUser;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subtask>
 */
class SubtaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'deadline' => Carbon::now()->timestamp + 100,
            'project_user_id' => ProjectUser::inRandomOrder()->first()->id,
            'task_id' => Task::inRandomOrder()->first()->id,
        ];
    }

    public function getAuthIdentifierName()
    {
    }

    public function getAuthIdentifier()
    {
    }

    public function getAuthPassword()
    {
    }

    public function getRememberToken()
    {
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
    }
}
