<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_task()
    {
        $response = $this->post('/tasks', []);
        $response->assertRedirect('/login');
    }

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->actingAs($user)
            ->post('/tasks', [
                'name' => 'New Task',
                'status_id' => $status->id,
            ])->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    public function test_only_creator_can_delete_task()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $this->actingAs($other)
            ->delete("/tasks/{$task->id}")
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete("/tasks/{$task->id}")
            ->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
