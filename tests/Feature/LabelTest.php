<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function testGuestCannotAccessProtectedLabelRoutes(): void
    {
        $label = Label::factory()->create();

        $this->get(route('labels.create'))->assertRedirect(route('login'));
        $this->get(route('labels.edit', $label))->assertRedirect(route('login'));
        $this->post(route('labels.store'), [])->assertRedirect(route('login'));
        $this->put(route('labels.update', $label), [])->assertRedirect(route('login'));
        $this->delete(route('labels.destroy', $label))->assertRedirect(route('login'));
    }

    public function testUserCanCreateLabel(): void
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

    public function testUserCanUpdateLabel(): void
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

    public function testUserCanDeleteUnusedLabel(): void
    {
        $this->actingAs($this->user);

        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testUserCannotDeleteLabelAttachedToTask(): void
    {
        $this->actingAs($this->user);

        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label);

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('flash_notification.0.message', __('messages.Label delete failed'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
