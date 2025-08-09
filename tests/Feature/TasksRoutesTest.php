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

    public function testTasksIndexIsAccessibleToGuests(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testTasksCreateRequiresAuthentication(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertRedirect(route('login'));
    }

    public function testTasksCreateIsAccessibleToAuthenticatedUsers(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testTasksStoreRequiresAuthentication(): void
    {
        $response = $this->post(route('tasks.store'), []);

        $response->assertRedirect(route('login'));
    }

    public function testTasksStoreCreatesTask(): void
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

        $this->assertDatabaseHas(
            'tasks',
            [
                'name' => 'New Task',
                'description' => 'Test description',
                'status_id' => $status->id,
                'created_by_id' => $user->id,
            ]
        );
    }

    public function testTasksShowIsAccessibleToGuests(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response->assertOk();
    }

    public function testTasksEditRequiresAuthentication(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertRedirect(route('login'));
    }

    public function testTasksEditIsAccessibleToAuthenticatedUsers(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertOk();
    }

    public function testTasksUpdateRequiresAuthentication(): void
    {
        $task = Task::factory()->create();

        $response = $this->patch(
            route('tasks.update', $task),
            ['name' => 'Updated']
        );

        $response->assertRedirect(route('login'));
    }

    public function testTasksUpdateUpdatesTask(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $task = Task::factory()->create(
            [
                'name' => 'Old Task',
                'status_id' => $status->id,
            ]
        );

        $newData = [
            'name' => 'Updated Task',
            'description' => 'Updated description',
            'status_id' => $status->id,
            'assigned_to_id' => null,
            'labels' => [$label->id],
        ];

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), $newData);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'name' => 'Updated Task',
            ]
        );
    }

    public function testTasksDestroyRequiresAuthentication(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('login'));
    }

    public function testTasksDestroyDeletesTaskIfAuthorized(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing(
            'tasks',
            [
                'id' => $task->id,
            ]
        );
    }

    public function testTasksDestroyForbiddenForNonAuthor(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertForbidden();

        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
            ]
        );
    }
}
