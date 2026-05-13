<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MetricsService;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    protected $metrics;

    public function __construct(MetricsService $metrics){
        $this->metrics = $metrics;
    }

    public function index(Request $request)
    {
        $tenant_id = $request->get('tenant_id');

        if (empty($tenant_id)) {
            return response()->json(['error' => 'tenant_id query parameter is required'], 422);
        }

        return response()->json([
            'mrr' => $this->metrics->getMRR($tenant_id),
            'usage_stats' => $this->metrics->getUsageStats($tenant_id),
        ]);
    }

    public function trend(Request $request)
    {
        $tenantId = $request->query('tenant_id');

        // We just ask the service for the data
        $trend = $this->metrics->getTrendData($tenantId);

        return response()->json([
            'status' => 'success',
            'data' => $trend
        ]);
    }
}
