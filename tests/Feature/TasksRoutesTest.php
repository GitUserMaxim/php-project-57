<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_index_is_accessible_to_guests(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function test_tasks_create_requires_authentication(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_tasks_create_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tasks.create'));
        $response->assertOk();
    }


    public function test_tasks_store_requires_authentication(): void
    {
        $response = $this->post(route('tasks.store'), []);
        $response->assertRedirect(route('login'));
    }


    public function test_tasks_store_creates_task(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $data = [
            'name' => 'New Task',
            'description' => 'Test description',
            'status_id' => $status->id,
            'assigned_to_id' => null,
            'labels' => [$label->id],
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'description' => 'Test description',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
        ]);
    }

    public function test_tasks_show_is_accessible_to_guests(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
    }

    public function test_tasks_edit_requires_authentication(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertRedirect(route('login'));
    }

    public function test_tasks_edit_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    public function test_tasks_update_requires_authentication(): void
    {
        $task = Task::factory()->create();
        $response = $this->patch(route('tasks.update', $task), ['name' => 'Updated']);
        $response->assertRedirect(route('login'));
    }

    public function test_tasks_update_updates_task(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $task = Task::factory()->create([
            'name' => 'Old Task',
            'status_id' => $status->id,
        ]);

        $newData = [
            'name' => 'Updated Task',
            'description' => 'Updated description',
            'status_id' => $status->id,
            'assigned_to_id' => null,
            'labels' => [$label->id],
        ];

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), $newData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Updated Task']);
    }

    public function test_tasks_destroy_requires_authentication(): void
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('login'));
    }


    public function test_tasks_destroy_deletes_task_if_authorized(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_tasks_destroy_forbidden_for_non_author(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
