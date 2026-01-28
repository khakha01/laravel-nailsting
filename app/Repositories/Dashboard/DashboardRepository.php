<?php

namespace App\Repositories\Dashboard;

use App\Repositories\Booking\BookingRepositoryInterface;
use App\Repositories\Booking\NailBookingRepositoryInterface;
use App\Repositories\Nail\NailRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function __construct(
        protected BookingRepositoryInterface $bookingRepo,
        protected NailBookingRepositoryInterface $nailBookingRepo,
        protected NailRepositoryInterface $nailRepo,
        protected ProductRepositoryInterface $productRepo,
        protected AdminRepositoryInterface $adminRepo
    ) {
    }

    public function getStats(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Booking Stats
        $todayBookings = $this->bookingRepo->countByDate($today) + $this->nailBookingRepo->countByDate($today);
        $yesterdayBookings = $this->bookingRepo->countByDate($yesterday) + $this->nailBookingRepo->countByDate($yesterday);
        $bookingGrowth = $this->calculateGrowth($todayBookings, $yesterdayBookings);

        // Revenue Stats
        $thisMonthRevenue = $this->bookingRepo->sumRevenueBetween($startOfMonth, $endOfMonth) +
            $this->nailBookingRepo->sumRevenueBetween($startOfMonth, $endOfMonth);

        $lastMonthRevenue = $this->bookingRepo->sumRevenueBetween($lastMonthStart, $lastMonthEnd) +
            $this->nailBookingRepo->sumRevenueBetween($lastMonthStart, $lastMonthEnd);

        $revenueGrowth = $this->calculateGrowth($thisMonthRevenue, $lastMonthRevenue);

        // Customer Stats
        $bookingPhones = $this->bookingRepo->getUniqueCustomerPhones()->toArray();
        $nailBookingPhones = $this->nailBookingRepo->getUniqueCustomerPhones()->toArray();
        $totalCustomers = count(array_unique(array_merge($bookingPhones, $nailBookingPhones)));

        return [
            'today_bookings' => [
                'value' => $todayBookings,
                'growth' => $bookingGrowth,
                'label' => 'Lịch hẹn hôm nay'
            ],
            'monthly_revenue' => [
                'value' => $thisMonthRevenue,
                'growth' => $revenueGrowth,
                'label' => 'Doanh thu tháng này'
            ],
            'total_customers' => [
                'value' => $totalCustomers,
                'label' => 'Tổng khách hàng'
            ],
            'inventory' => [
                'nails' => $this->nailRepo->countAll(),
                'products' => $this->productRepo->countAll(),
                'admins' => $this->adminRepo->countAll()
            ]
        ];
    }

    public function getRecentBookings(int $limit = 8): Collection
    {
        return $this->bookingRepo->getRecentBookings($limit)
            ->concat($this->nailBookingRepo->getRecentBookings($limit))
            ->sortByDesc('created_at')
            ->take($limit);
    }

    public function getStatusDistribution(): array
    {
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $dist = [];
        foreach ($statuses as $status) {
            $dist[$status] = $this->bookingRepo->countByStatus($status) +
                $this->nailBookingRepo->countByStatus($status);
        }
        return $dist;
    }

    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }
}
