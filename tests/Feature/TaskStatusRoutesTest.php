<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_task_status_index()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function test_guest_cannot_view_create_task_status_page()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_view_create_task_status_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function test_guest_cannot_store_task_status()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'In progress',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'In progress']);
    }

    public function test_auth_user_can_store_task_status()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('task_statuses.store'), [
            'name' => 'In progress',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'In progress']);
    }

    public function test_guest_cannot_view_edit_task_status_page()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_view_edit_task_status_page()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.edit', $status));
        $response->assertOk();
    }

    public function test_guest_cannot_update_task_status()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => 'Updated name',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'Updated name']);
    }

    public function test_auth_user_can_update_task_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Old name']);

        $response = $this->actingAs($user)->patch(route('task_statuses.update', $status), [
            'name' => 'Updated name',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Updated name']);
    }

    public function test_guest_cannot_delete_task_status()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function test_auth_user_can_delete_unused_task_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }
}
