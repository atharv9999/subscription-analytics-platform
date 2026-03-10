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
        $tenant = \App\Models\Tenant::factory()->create([
            'name' => 'Atharv Analytics Pune',
            'domain' => 'atharv.test',
        ]);

        \App\Models\User::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Atharv Developer',
            'email' => 'admin@atharv.test',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        \App\Models\User::factory()
            ->count(10)
            ->create([
                'tenant_id' => $tenant->id
            ]);
    }
}
