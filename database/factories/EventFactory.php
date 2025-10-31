<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('now', '+6 months');
        $endTime = fake()->dateTimeBetween($startTime, $startTime->format('Y-m-d H:i:s').' +6 hours');

        return [
            'user_id' => User::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }

    /**
     * Create an event that has already ended.
     */
    public function past(): static
    {
        return $this->state(function (array $attributes) {
            $startTime = fake()->dateTimeBetween('-6 months', '-1 day');
            $endTime = fake()->dateTimeBetween($startTime, $startTime->format('Y-m-d H:i:s').' +6 hours');

            return [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        });
    }

    /**
     * Create an event happening today.
     */
    public function today(): static
    {
        return $this->state(function (array $attributes) {
            $startTime = fake()->dateTimeBetween('now', 'today 23:59:59');
            $endTime = fake()->dateTimeBetween($startTime, 'today 23:59:59');

            return [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        });
    }

    /**
     * Create an event without an end time.
     */
    public function withoutEndTime(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'end_time' => null,
            ];
        });
    }
}
