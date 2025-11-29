<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\BannerAnalytic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BannerService
{
    /**
     * Get active banners for a specific position
     */
    public function getActiveBanners(string $position)
    {
        $cacheKey = "banners_position_{$position}";
        
        return Cache::remember($cacheKey, 300, function () use ($position) {
            return Banner::where('position', $position)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('start_date')
                        ->orWhere('start_date', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Track banner impression
     */
    public function trackImpression(int $bannerId, ?int $userId = null): void
    {
        BannerAnalytic::create([
            'banner_id' => $bannerId,
            'user_id' => $userId,
            'event_type' => 'impression',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Update banner impression count
        Banner::where('id', $bannerId)->increment('impressions');
    }

    /**
     * Track banner click
     */
    public function trackClick(int $bannerId, ?int $userId = null): void
    {
        BannerAnalytic::create([
            'banner_id' => $bannerId,
            'user_id' => $userId,
            'event_type' => 'click',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Update banner click count
        Banner::where('id', $bannerId)->increment('clicks');
    }

    /**
     * Get banner analytics summary
     */
    public function getAnalytics(int $bannerId, int $days = 7): array
    {
        $startDate = now()->subDays($days);

        $analytics = BannerAnalytic::where('banner_id', $bannerId)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(CASE WHEN event_type = "impression" THEN 1 END) as impressions'),
                DB::raw('COUNT(CASE WHEN event_type = "click" THEN 1 END) as clicks')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalImpressions = $analytics->sum('impressions');
        $totalClicks = $analytics->sum('clicks');
        $ctr = $totalImpressions > 0 ? ($totalClicks / $totalImpressions) * 100 : 0;

        return [
            'daily_data' => $analytics,
            'total_impressions' => $totalImpressions,
            'total_clicks' => $totalClicks,
            'ctr' => round($ctr, 2),
        ];
    }

    /**
     * Get live viewer count (simulated)
     * In production, this would integrate with real-time analytics
     */
    public function getLiveViewers(): int
    {
        $cacheKey = 'live_viewers_count';
        
        return Cache::remember($cacheKey, 30, function () {
            // Simulate realistic viewer count based on time of day
            $hour = now()->hour;
            $baseCount = rand(50, 150);
            
            // Peak hours adjustment (10 AM - 10 PM)
            if ($hour >= 10 && $hour <= 22) {
                $baseCount = rand(200, 500);
            }
            
            return $baseCount;
        });
    }

    /**
     * Get recent purchase ticker data
     */
    public function getRecentPurchases(int $limit = 10): array
    {
        $cacheKey = 'recent_purchases_ticker';
        
        return Cache::remember($cacheKey, 60, function () use ($limit) {
            // Get real recent orders if available
            if (class_exists('App\Models\Order')) {
                $orders = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->join('products', 'orders.product_id', '=', 'products.id')
                    ->select(
                        'users.name as customer_name',
                        'products.name as product_name',
                        'orders.created_at'
                    )
                    ->where('orders.created_at', '>=', now()->subHours(24))
                    ->orderBy('orders.created_at', 'desc')
                    ->limit($limit)
                    ->get()
                    ->map(function ($order) {
                        return [
                            'customer' => $this->anonymizeCustomerName($order->customer_name),
                            'product' => $order->product_name,
                            'time' => $order->created_at,
                            'location' => $this->getRandomLocation(),
                        ];
                    })
                    ->toArray();

                return $orders ?: $this->generateMockPurchases($limit);
            }

            return $this->generateMockPurchases($limit);
        });
    }

    /**
     * Anonymize customer name for privacy
     */
    private function anonymizeCustomerName(string $name): string
    {
        $parts = explode(' ', $name);
        if (count($parts) > 1) {
            return $parts[0] . ' ' . substr($parts[1], 0, 1) . '.';
        }
        return substr($name, 0, 1) . str_repeat('*', strlen($name) - 1);
    }

    /**
     * Get random location for purchase ticker
     */
    private function getRandomLocation(): string
    {
        $locations = [
            'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai',
            'Kolkata', 'Pune', 'Ahmedabad', 'Jaipur', 'Surat'
        ];
        return $locations[array_rand($locations)];
    }

    /**
     * Generate mock purchases for demo
     */
    private function generateMockPurchases(int $limit): array
    {
        $purchases = [];
        $products = ['Urban Hoodie', 'Street Joggers', 'Graphic Tee', 'Bomber Jacket', 'Sneakers'];
        $names = ['Rajesh K.', 'Priya S.', 'Amit M.', 'Sneha R.', 'Vikram P.'];

        for ($i = 0; $i < $limit; $i++) {
            $purchases[] = [
                'customer' => $names[array_rand($names)],
                'product' => $products[array_rand($products)],
                'time' => now()->subMinutes(rand(1, 180)),
                'location' => $this->getRandomLocation(),
            ];
        }

        return $purchases;
    }

    /**
     * Check if drop notification should be shown
     */
    public function shouldShowDropNotification(): bool
    {
        $cacheKey = 'drop_notification_shown_' . (auth()->id() ?? request()->ip());
        
        // Don't show if already seen in last 24 hours
        if (Cache::has($cacheKey)) {
            return false;
        }

        // Mark as shown for 24 hours
        Cache::put($cacheKey, true, 86400);
        
        return true;
    }

    /**
     * Clear banner cache
     */
    public function clearCache(?string $position = null): void
    {
        if ($position) {
            Cache::forget("banners_position_{$position}");
        } else {
            // Clear all banner caches
            $positions = ['hero', 'header-sticky', 'mid-page', 'footer'];
            foreach ($positions as $pos) {
                Cache::forget("banners_position_{$pos}");
            }
        }
    }

    /**
     * Get banner performance ranking
     */
    public function getBannerPerformanceRanking(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        return Banner::select('banners.*')
            ->selectRaw('(clicks::float / GREATEST(impressions, 1)) * 100 as ctr')
            ->where('created_at', '>=', $startDate)
            ->where('impressions', '>', 0)
            ->orderByDesc('ctr')
            ->limit(10)
            ->get()
            ->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'impressions' => $banner->impressions,
                    'clicks' => $banner->clicks,
                    'ctr' => round($banner->ctr, 2),
                ];
            })
            ->toArray();
    }

    /**
     * Optimize video for web delivery
     */
    public function optimizeVideoUrl(string $url): string
    {
        // Add parameters for optimized delivery
        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . 'autoplay=1&muted=1&loop=1&preload=metadata';
    }
}
