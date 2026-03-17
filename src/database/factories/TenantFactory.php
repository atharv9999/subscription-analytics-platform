<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
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
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
            'status' => $this->faker->randomElement(['active', 'trialing', 'suspended']),
        ];
    }
}
