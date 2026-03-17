<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscriptionFactory extends Factory
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
            'customer_id' => \App\Models\Customer::factory(),
            'plan_id' => \App\Models\Plan::factory(),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'past_due', 'cancelled']),
            'current_period_start' => now()->subDays(15),
            'current_period_end' => now()->addDays(15),
            'metadata' => ['source' => 'organic']
        ];
    }
}
