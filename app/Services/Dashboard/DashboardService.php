<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\DashboardRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected DashboardRepositoryInterface $dashboardRepo
    ) {
    }

    /**
     * Get all dashboard statistics
     */
    public function getDashboardStats(): array
    {
        return [
            'stats' => $this->dashboardRepo->getStats(),
            'recent_bookings' => $this->dashboardRepo->getRecentBookings(8),
            'status_distribution' => $this->dashboardRepo->getStatusDistribution()
        ];
    }
}
