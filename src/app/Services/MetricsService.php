<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\UsageEvent;
use Illuminate\Support\Facades\DB;

class MetricsService {
    
    public function getMRR(): float {
        return (float) Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.base_price');
    }

    public function getActiveCount(): int {
        return Subscription::where('status', 'active')->count();
    }

    public function getChurnRate(): float {
        // Temporary mock logic for the UI
        return 2.4; 
    }

    public function getUsageStats(): array {
        return UsageEvent::select('type', DB::raw('SUM(quantity) as total'))
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function getTrendData() {
        return Subscription::query()
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->select(
                DB::raw("TO_CHAR(subscriptions.created_at, 'Mon') as month"),
                DB::raw("SUM(plans.base_price) as revenue"),
                DB::raw("MAX(subscriptions.created_at) as sort_date")
            )
            ->groupBy('month')
            ->orderBy('sort_date', 'ASC')
            ->get();
    }
}