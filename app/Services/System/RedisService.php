<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class RedisService
{
    /**
     * Get Redis statistics
     *
     * @return array
     */
    public function getInfo()
    {
        try {
            $redis = Redis::connection('cache');
            $info = $redis->info();

            // Get database number from config
            $dbNum = config('database.redis.cache.database', 1);
            $dbKeyspace = $info["db$dbNum"] ?? null;

            // Try to get key count from info first, fallback to dbSize
            $totalKeys = 0;
            if ($dbKeyspace) {
                // dbKeyspace is string like "keys=5,expires=0,avg_ttl=0"
                if (preg_match('/keys=(\d+)/', $dbKeyspace, $matches)) {
                    $totalKeys = (int) $matches[1];
                }
            }

            if ($totalKeys === 0) {
                $totalKeys = $redis->dbSize();
            }

            return [
                'status' => 'connected',
                'version' => $info['redis_version'] ?? 'Unknown',
                'uptime' => $this->formatUptime($info['uptime_in_seconds'] ?? 0),
                'memory_used' => $info['used_memory_human'] ?? '0B',
                'memory_peak' => $info['used_memory_peak_human'] ?? '0B',
                'total_keys' => $totalKeys,
                'clients' => $info['connected_clients'] ?? 0,
                'cpu_usage' => ($info['used_cpu_user'] ?? 0) + ($info['used_cpu_sys'] ?? 0),
                'db_index' => $dbNum,
                'raw_info' => $info,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'disconnected',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get list of keys with their patterns and counts
     *
     * @return array
     */
    public function getKeyStats()
    {
        try {
            $redis = Redis::connection('cache');
            $keys = $redis->keys('*');
            $stats = [];
            $prefix = config('cache.prefix');

            foreach ($keys as $key) {
                // Remove prefix if exists
                if ($prefix && strpos($key, $prefix) === 0) {
                    $cleanKey = substr($key, strlen($prefix));
                } else {
                    $cleanKey = $key;
                }

                // Group by first part of key
                $parts = explode(':', $cleanKey);
                $group = $parts[0] ?? 'other';

                if (!isset($stats[$group])) {
                    $stats[$group] = [
                        'count' => 0,
                        'keys' => []
                    ];
                }

                $stats[$group]['count']++;
                $stats[$group]['keys'][] = $cleanKey;
            }

            // Map and add descriptions
            $mappedStats = [];
            $descriptions = [
                'posts' => [
                    'title' => 'Bài viết & Blog',
                    'desc' => 'Dữ liệu nội dung bài viết, slug và danh sách hiển thị blog cho người dùng.',
                    'icon' => 'document-text'
                ],
                'post_categories' => [
                    'title' => 'Danh mục Blog',
                    'desc' => 'Cấu trúc cây danh mục bài viết và phân loại dữ liệu blog.',
                    'icon' => 'folder-open'
                ],
                'post_tags' => [
                    'title' => 'Thẻ bài viết',
                    'desc' => 'Các từ khóa (tags) dùng để phân loại và tìm kiếm bài viết nhanh hơn.',
                    'icon' => 'tag'
                ],
                'categories' => [
                    'title' => 'Danh mục Dịch vụ',
                    'desc' => 'Danh mục sản phẩm, dịch vụ làm đẹp chính trên hệ thống.',
                    'icon' => 'tag'
                ],
                'products' => [
                    'title' => 'Dịch vụ & Sản phẩm',
                    'desc' => 'Chi tiết các gói dịch vụ làm nail, giá cả và thông tin chi tiết.',
                    'icon' => 'shopping-bag'
                ],
                'nail_categories' => [
                    'title' => 'Danh mục Nail-box',
                    'desc' => 'Phân loại các mẫu Nail-box có sẵn trong cửa hàng.',
                    'icon' => 'folder-open'
                ],
                'nails' => [
                    'title' => 'Mẫu Nail (Nail-box)',
                    'desc' => 'Dữ liệu về các mẫu nail, thiết kế và bộ sưu tập Nail-box.',
                    'icon' => 'sparkles'
                ],
                'bookings' => [
                    'title' => 'Lịch hẹn Dịch vụ',
                    'desc' => 'Dữ liệu tạm thời về khách hàng và thông tin đặt lịch hẹn làm đẹp.',
                    'icon' => 'calendar'
                ],
                'nail_bookings' => [
                    'title' => 'Lịch hẹn Nail-box',
                    'desc' => 'Các yêu cầu đặt hàng và lịch làm việc dành riêng cho Nail-box.',
                    'icon' => 'sparkles'
                ],
                'booking_dates' => [
                    'title' => 'Ngày làm việc',
                    'desc' => 'Cache danh sách các ngày cửa hàng mở cửa và nhận lịch.',
                    'icon' => 'calendar'
                ],
                'booking_time_slots' => [
                    'title' => 'Khung giờ đặt lịch',
                    'desc' => 'Các khoảng thời gian còn trống trong ngày để khách chọn lịch.',
                    'icon' => 'cog'
                ],
                'banners' => [
                    'title' => 'Banner & Hình ảnh',
                    'desc' => 'Cache cho các tấm ảnh banner quảng bá trên trang chủ.',
                    'icon' => 'photograph'
                ],
                'admins' => [
                    'title' => 'Dữ liệu Quản trị',
                    'desc' => 'Thông tin phiên bản làm việc và quyền hạn truy cập của nhân viên.',
                    'icon' => 'user-group'
                ],
                'permissions' => [
                    'title' => 'Quyền hạn hệ thống',
                    'desc' => 'Danh sách các quyền truy cập được phân bổ cho các nhóm admin.',
                    'icon' => 'user-group'
                ],
                'settings' => [
                    'title' => 'Cài đặt hệ thống',
                    'desc' => 'Thông tin cấu hình chung của website như số điện thoại, địa chỉ, logo.',
                    'icon' => 'cog'
                ],
                'dashboard' => [
                    'title' => 'Báo cáo Dashboard',
                    'desc' => 'Dữ liệu thống kê nhanh trên trang tổng quan (doanh thu, lượt đặt).',
                    'icon' => 'database'
                ],
            ];

            foreach ($stats as $group => $data) {
                $mappedStats[$group] = array_merge($data, [
                    'display_title' => $descriptions[$group]['title'] ?? 'Dữ liệu khác (' . strtoupper($group) . ')',
                    'display_desc' => $descriptions[$group]['desc'] ?? 'Các dữ liệu cache hệ thống tự động sinh ra trong quá trình vận hành.',
                    'icon' => $descriptions[$group]['icon'] ?? 'database'
                ]);
            }

            return $mappedStats;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Clear all cache
     *
     * @return bool
     */
    public function clearCache()
    {
        return Cache::flush();
    }

    /**
     * Delete specific key pattern
     *
     * @param string $pattern
     * @return int
     */
    public function deletePattern($pattern)
    {
        $redis = Redis::connection('cache');
        $keys = $redis->keys($pattern);
        if (!empty($keys)) {
            return $redis->del($keys);
        }
        return 0;
    }

    /**
     * Format uptime seconds to human readable
     *
     * @param int $seconds
     * @return string
     */
    private function formatUptime($seconds)
    {
        if ($seconds < 60)
            return $seconds . 's';
        if ($seconds < 3600)
            return floor($seconds / 60) . 'm ' . ($seconds % 60) . 's';
        if ($seconds < 86400)
            return floor($seconds / 3600) . 'h ' . floor(($seconds % 3600) / 60) . 'm';
        return floor($seconds / 86400) . 'd ' . floor(($seconds % 86400) / 3600) . 'h';
    }
}
