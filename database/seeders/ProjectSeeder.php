<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i =1; $i<8;$i++){
            Project::create([
               'name' => 'project'.$i,
            ]);
        }
    }
}
