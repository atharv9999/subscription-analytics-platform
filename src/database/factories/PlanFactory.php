<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
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
            'product_id' => \App\Models\Product::factory(),
            'name' => $this->faker->randomElement(['Basic', 'Pro', 'Enterprise']),
            'billing_cycle' => $this->faker->randomElement(['monthly', 'yearly']),
            'pricing_model' => 'flat_rate',
            'base_price' => $this->faker->randomElement([10.00, 29.00, 99.00]),
            'currency' => 'USD'
        ];
    }
}
