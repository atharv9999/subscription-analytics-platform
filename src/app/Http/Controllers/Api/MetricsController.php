<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MetricsService;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    protected $metrics;

    public function __construct(MetricsService $metrics) {
        $this->metrics = $metrics;
    }

    public function index(Request $request)
    {
        // Notice we removed the 'tenant_id' check. 
        // The Identity is handled by Sanctum and the Scope automatically.
        return response()->json([
            'status' => 'success',
            'data' => [
                'mrr' => $this->metrics->getMRR(),
                'active_subscriptions' => $this->metrics->getActiveCount(),
                'churn_rate' => $this->metrics->getChurnRate(),
                'usage_stats' => $this->metrics->getUsageStats(),
            ]
        ]);
    }

    public function trend(Request $request)
    {
        // No arguments needed here anymore
        $trend = $this->metrics->getTrendData();

        return response()->json([
            'status' => 'success',
            'data' => $trend
        ]);
    }
}