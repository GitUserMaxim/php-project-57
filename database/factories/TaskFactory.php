<?php


namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'status_id' => TaskStatus::factory(),
            'created_by_id' => User::factory(),
        ];
    }
}
