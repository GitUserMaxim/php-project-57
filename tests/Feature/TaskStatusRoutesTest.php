<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewTaskStatusIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testGuestCannotViewCreateTaskStatusPage()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertRedirect(route('login'));
    }

    public function testAuthUserCanViewCreateTaskStatusPage()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testGuestCannotStoreTaskStatus()
    {
        $response = $this->post(
            route('task_statuses.store'),
            [
                'name' => 'In progress',
            ]
        );
        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'In progress']);
    }

    public function testAuthUserCanStoreTaskStatus()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('task_statuses.store'),
            [
                'name' => 'In progress',
            ]
        );

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'In progress']);
    }

    public function testGuestCannotViewEditTaskStatusPage()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertRedirect(route('login'));
    }

    public function testAuthUserCanViewEditTaskStatusPage()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.edit', $status));
        $response->assertOk();
    }

    public function testGuestCannotUpdateTaskStatus()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->patch(
            route('task_statuses.update', $status),
            [
                'name' => 'Updated name',
            ]
        );

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'Updated name']);
    }

    public function testAuthUserCanUpdateTaskStatus()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Old name']);

        $response = $this->actingAs($user)->patch(
            route('task_statuses.update', $status),
            [
                'name' => 'Updated name',
            ]
        );

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Updated name']);
    }

    public function testGuestCannotDeleteTaskStatus()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testAuthUserCanDeleteUnusedTaskStatus()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }
}
