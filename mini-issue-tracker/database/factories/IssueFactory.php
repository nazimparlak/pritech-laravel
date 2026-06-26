<?php

namespace Database\Factories;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(), // Bağımsız üretilirse otomatik proje bağlar
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->text(300),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date' => $this->faker->optional(0.8)->dateTimeBetween('now', '+2 months'), // %80 ihtimalle tarihi olur
        ];
    }
}
