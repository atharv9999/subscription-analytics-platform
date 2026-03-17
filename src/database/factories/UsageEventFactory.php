<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UsageEvent>
 */
class UsageEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) str()->uuid(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'subscription_id' => \App\Models\Subscription::factory(),
            'type' => $this->faker->randomElement(['api_call', 'data_gb', 'seat_usage']),
            'quantity' => $this->faker->randomFloat(4, 0, 100),
            'event_time' => now()->subMinutes(rand(1, 43200)), // Random time in last 30 days
        ];
    }
}
