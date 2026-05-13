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
        // Spread the data over the last 12 months
        $createdAt = $this->faker->dateTimeBetween('-12 months', 'now');
        return [
            'id' => (string) str()->uuid(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'customer_id' => \App\Models\Customer::factory(),
            'plan_id' => \App\Models\Plan::factory(),
            'status' => 'active', // can use $this->faker->randomElement(['active', 'active', 'active', 'past_due', 'cancelled']),
                        //  but for simplicity we'll set most to 'active' to make the charts look better
            'current_period_start' => $createdAt, // Start when created
            'current_period_end' => (clone $createdAt)->modify('+1 month'), // End 1 month later
            'created_at' => $createdAt,
            'metadata' => ['source' => 'organic']
        ];
    }
}
