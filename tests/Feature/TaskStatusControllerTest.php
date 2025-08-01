<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\TaskStatusSeeder::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function guest_cannot_access_create_page()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertRedirect(route('login'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function guest_cannot_store_status()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'New Status',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'New Status']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
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

    #[\PHPUnit\Framework\Attributes\Test]
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

    #[\PHPUnit\Framework\Attributes\Test]
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

    #[\PHPUnit\Framework\Attributes\Test]
    public function authenticated_user_can_delete_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->actingAs($user);

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function guest_cannot_delete_status()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }
}
