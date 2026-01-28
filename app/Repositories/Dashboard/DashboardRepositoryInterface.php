<?php

namespace App\Repositories\Dashboard;

interface DashboardRepositoryInterface
{
    /**
     * Get main dashboard statistics
     */
    public function getStats(): array;

    /**
     * Get combined recent bookings
     */
    public function getRecentBookings(int $limit = 8): \Illuminate\Support\Collection;

    /**
     * Get booking status distribution
     */
    public function getStatusDistribution(): array;
}
