<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(3)->create()->each(function ($user) {
            $projects = Project::factory(2)->create(['owner_id' => $user->id]);

            $projects->each(function ($project) {
                $userIds = User::pluck('id')->toArray();

                Task::factory(5)->create([
                    'project_id' => $project->id,
                    'assigned_to' => fake()->randomElement($userIds),
                ]);
            });
        });
    }
}
