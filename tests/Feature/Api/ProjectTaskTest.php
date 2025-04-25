<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_project()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/projects', [
            'title' => 'Nouveau Projet',
            'description' => 'Description test',
            'owner_id' => $user->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Nouveau Projet']);

        $this->assertDatabaseHas('projects', ['title' => 'Nouveau Projet']);
    }

    /** @test */
    public function it_can_assign_a_task_to_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);
        $assignee = User::factory()->create();

        $response = $this->postJson('/api/tasks', [
            'title' => 'Tâche test',
            'description' => 'Faire ceci',
            'status' => 'pending',
            'project_id' => $project->id,
            'assigned_to' => $assignee->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Tâche test']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Tâche test',
            'assigned_to' => $assignee->id,
        ]);
    }

    /** @test */
    public function it_can_filter_tasks_by_assigned_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $task1 = Task::factory()->create(['project_id' => $project->id, 'assigned_to' => $user->id]);
        $task2 = Task::factory()->create(); // autre user

        $response = $this->getJson('/api/tasks-assigned?user_id=' . $user->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $task1->id])
                 ->assertJsonMissing(['id' => $task2->id]);
    }

    /** @test */
public function debug_routes_are_loaded()
{
    $this->getJson('/api/debug-route')->assertStatus(200)->assertJson(['ok' => true]);
}

}
