<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerAnalyticsController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * Track banner impression
     */
    public function trackImpression(Request $request, Banner $banner): JsonResponse
    {
        try {
            $userId = auth()->id();
            $this->bannerService->trackImpression($banner->id, $userId);

            return response()->json([
                'success' => true,
                'message' => 'Impression tracked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track impression'
            ], 500);
        }
    }

    /**
     * Track banner click
     */
    public function trackClick(Request $request, Banner $banner): JsonResponse
    {
        try {
            $userId = auth()->id();
            $this->bannerService->trackClick($banner->id, $userId);

            return response()->json([
                'success' => true,
                'message' => 'Click tracked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track click'
            ], 500);
        }
    }

    /**
     * Get live statistics
     */
    public function getLiveStats(Request $request): JsonResponse
    {
        try {
            $liveViewers = $this->bannerService->getLiveViewers();

            return response()->json([
                'success' => true,
                'data' => [
                    'live_viewers' => $liveViewers,
                    'last_updated' => now()->toIso8601String(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get live stats'
            ], 500);
        }
    }

    /**
     * Get recent purchases for ticker
     */
    public function getRecentPurchases(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $purchases = $this->bannerService->getRecentPurchases($limit);

            return response()->json([
                'success' => true,
                'data' => $purchases
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get recent purchases'
            ], 500);
        }
    }
}
