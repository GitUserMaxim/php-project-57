<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use App\Models\Task;

class LabelTest extends TestCase
{
    use RefreshDatabase;

     protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guest_cannot_access_protected_label_routes()
    {
        $label = Label::factory()->create();

        $this->get(route('labels.create'))->assertRedirect(route('login'));
        $this->get(route('labels.edit', $label))->assertRedirect(route('login'));
        $this->post(route('labels.store'), [])->assertRedirect(route('login'));
        $this->put(route('labels.update', $label), [])->assertRedirect(route('login'));
        $this->delete(route('labels.destroy', $label))->assertRedirect(route('login'));
    }

    public function test_user_can_create_label()
    {
        $this->actingAs($this->user);

        $data = [
            'name' => 'Bug',
            'description' => 'Something is broken',
        ];

        $response = $this->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function test_user_can_update_label()
    {
        $this->actingAs($this->user);

        $label = Label::factory()->create();

        $updated = [
            'name' => 'Feature',
            'description' => 'New feature',
        ];

        $response = $this->put(route('labels.update', $label), $updated);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $updated);
    }

    public function test_user_can_delete_unused_label()
    {
        $this->actingAs($this->user);

        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function test_user_cannot_delete_label_attached_to_task()
    {
        $this->actingAs($this->user);

        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label);

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('error', __('messages.Label delete failed'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
