<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'name' => $this->faker->randomElement([
                'AI Content Generator',
                'Cloud Storage API',
                'Premium News Feed',
                'SEO Optimizer'
            ]),
            'description' => $this->faker->sentence(),
            'is_active' => true
        ];
    }
}
