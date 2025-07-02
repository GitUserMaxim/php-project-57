<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_task_statuses_index()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.index');
        $response->assertSee($status->name);
    }

    /** @test */
    public function guest_cannot_access_create_page()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_store_status()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'New Status',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'New Status']);
    }

    /** @test */
    public function authenticated_user_can_create_status()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => 'New Status',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'New Status']);
    }

    /** @test */
    public function authenticated_user_can_edit_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Old Status']);

        $this->actingAs($user);

        $response = $this->get(route('task_statuses.edit', $status));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.edit');
        $response->assertSee('Old Status');
    }

    /** @test */
    public function authenticated_user_can_update_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Old Status']);

        $this->actingAs($user);

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => 'Updated Status',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Updated Status']);
    }

} 
   
   
    // /** @test */
    // public function authenticated_user_can_delete_unused_status()
    // {
    //     $user = User::factory()->create();
    //     $status = TaskStatus::factory()->create();

    //     $this->actingAs($user);

    //     $response = $this->delete(route('task_statuses.destroy', $status));

    //     $response->assertRedirect(route('task_statuses
