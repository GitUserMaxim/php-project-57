<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LabelsRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_labels_index_is_accessible_to_guests(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function test_labels_create_requires_authentication(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_labels_create_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function test_labels_store_requires_authentication(): void
    {
        $response = $this->post(route('labels.store'), [
            'name' => 'Bug',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_labels_store_creates_new_label(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Bug', 'description' => 'Fix it'];

        $response = $this->actingAs($user)->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function test_labels_edit_requires_authentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->get(route('labels.edit', $label));
        $response->assertRedirect(route('login'));
    }

    public function test_labels_edit_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function test_labels_update_requires_authentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->patch(route('labels.update', $label), ['name' => 'Updated']);
        $response->assertRedirect(route('login'));
    }

    public function test_labels_update_updates_label(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Original']);

        $response = $this->actingAs($user)->patch(route('labels.update', $label), [
            'name' => 'Updated',
        ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id, 'name' => 'Updated']);
    }

    public function test_labels_destroy_requires_authentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('login'));
    }

    public function test_labels_destroy_deletes_label(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function test_labels_destroy_fails_if_label_attached_to_task(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label);

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
