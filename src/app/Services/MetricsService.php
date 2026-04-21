<?php

    namespace App\Services;

    use App\Models\Subscription;
    use App\Models\UsageEvent;
    use Illuminate\Support\Facades\DB;

    class MetricsService{
        public function getMRR(string $tenant_id): float {
            return Subscription::where('tenant_id', $tenant_id)->where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.base_price');
        }

        public function getUsageStats(string $tenant_id): array {
            return UsageEvent::where('tenant_id', $tenant_id)->select('type', DB::raw('SUM(quantity) as total'))
            ->groupBy('type')->get()->toArray();
        }
    }