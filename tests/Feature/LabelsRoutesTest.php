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

    public function testLabelsIndexIsAccessibleToGuests(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testLabelsCreateRequiresAuthentication(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertRedirect(route('login'));
    }

    public function testLabelsCreateIsAccessibleToAuthenticatedUsers(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testLabelsStoreRequiresAuthentication(): void
    {
        $response = $this->post(
            route('labels.store'),
            [
                'name' => 'Bug',
            ]
        );
        $response->assertRedirect(route('login'));
    }

    public function testLabelsStoreCreatesNewLabel(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Bug', 'description' => 'Fix it'];

        $response = $this->actingAs($user)->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function testLabelsEditRequiresAuthentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->get(route('labels.edit', $label));
        $response->assertRedirect(route('login'));
    }

    public function testLabelsEditIsAccessibleToAuthenticatedUsers(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testLabelsUpdateRequiresAuthentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->patch(route('labels.update', $label), ['name' => 'Updated']);
        $response->assertRedirect(route('login'));
    }

    public function testLabelsUpdateUpdatesLabel(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Original']);

        $response = $this->actingAs($user)->patch(
            route('labels.update', $label),
            [
                'name' => 'Updated',
            ]
        );

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id, 'name' => 'Updated']);
    }

    public function testLabelsDestroyRequiresAuthentication(): void
    {
        $label = Label::factory()->create();
        $response = $this->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('login'));
    }

    public function testLabelsDestroyDeletesLabel(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelsDestroyFailsIfLabelAttachedToTask(): void
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
