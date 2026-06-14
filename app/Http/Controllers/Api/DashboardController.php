<?php

namespace App\Http\Controllers\Api;

use App\Contracts\DashboardServiceInterface;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected DashboardServiceInterface $dashboardService;

    public function __construct(DashboardServiceInterface $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->dashboardService->getSummary(),
        ]);
    }
}