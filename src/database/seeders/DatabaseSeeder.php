<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the Tenant
        $tenant = \App\Models\Tenant::factory()->create([
            'name' => 'Atharv Analytics Pune',
            'domain' => 'atharv.test',
        ]);

        // 2. Create the Admin User
        \App\Models\User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'admin@atharv.test',
            'password' => bcrypt('password123'),
        ]);

        // 3. Create a Product
        $product = \App\Models\Product::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'SaaS Insights Engine'
        ]);

        // 4. Create the Plans as a Collection (So we can use random() later)
        $planData = [
            ['name' => 'Basic', 'base_price' => 19.00, 'per_unit_price' => 0.01],
            ['name' => 'Pro', 'base_price' => 49.00, 'per_unit_price' => 0.05],
            ['name' => 'Enterprise', 'base_price' => 199.00, 'per_unit_price' => 0.10]
        ];

        $createdPlans = collect(); // We will store the actual database objects here

        foreach ($planData as $data) {
            $createdPlans->push(
                \App\Models\Plan::factory()->create(array_merge($data, [
                    'tenant_id' => $tenant->id,
                    'product_id' => $product->id,
                    'billing_cycle' => 'monthly',
                ]))
            );
        }

        // 5. Create 50 Customers and link them to a RANDOM plan from our list
        \App\Models\Customer::factory()
            ->count(50)
            ->create(['tenant_id' => $tenant->id])
            ->each(function ($customer) use ($tenant, $createdPlans) {
                \App\Models\Subscription::factory()->create([
                    'tenant_id' => $tenant->id,
                    'customer_id' => $customer->id,
                    'plan_id' => $createdPlans->random()->id, // Now this works!
                    'status' => 'active',
                ]);
            });
    }
}
