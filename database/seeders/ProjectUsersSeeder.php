<?php

namespace Database\Seeders;


use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(100);
        $role = ['OWNER', 'MEMBER', 'VIEWER'];
        for ($i = 1; $i < 4; $i++) {
            $project = Project::inRandomOrder()->first();
            ProjectUser::create([
                'role' => $role[rand(0, 2)],
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
        }


        for ($i = 1; $i < 16; $i++) {
            $user = User::inRandomOrder()->first();
            $project = Project::inRandomOrder()->first();
            ProjectUser::create([
                'role' => $role[rand(0, 2)],
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
        }
    }
}
