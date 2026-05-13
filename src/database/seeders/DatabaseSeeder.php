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
        $tenantNames = ['Pune Tech Hub', 'Delta AI', 'Medcure', 'PowerData', 'GreenEnergy'];

        foreach ($tenantNames as $name) {
            $tenant = \App\Models\Tenant::factory()->create([
                'name' => $name,
                'domain' => str()->slug($name) . '.test',
            ]);

            \App\Models\User::factory()->create([
                'tenant_id' => $tenant->id,
                'email' => "admin@" . str()->slug($name) . ".test",
            ]);

            $product = \App\Models\Product::factory()->create(['tenant_id' => $tenant->id]);

            $planData = [
                ['name' => 'Basic', 'base_price' => 19.00],
                ['name' => 'Pro', 'base_price' => 49.00],
                ['name' => 'Enterprise', 'base_price' => 199.00]
            ];

            $createdPlans = collect();
            foreach ($planData as $data) {
                $createdPlans->push(
                    \App\Models\Plan::factory()->create(array_merge($data, [
                        'product_id' => $product->id,
                        'billing_cycle' => 'monthly'
                    ]))
                );
            }

            $customerCount = rand(200, 250);
            
            \App\Models\Customer::factory()
                ->count($customerCount)
                ->create(['tenant_id' => $tenant->id])
                ->each(function ($customer) use ($tenant, $createdPlans) {
                    \App\Models\Subscription::factory()->create([
                        'tenant_id' => $tenant->id,
                        'customer_id' => $customer->id,
                        'plan_id' => $createdPlans->random()->id
                    ]);
                });
        }
    }
}
