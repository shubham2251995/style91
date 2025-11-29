<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerAnalyticsController;

Route::middleware('api')->prefix('api')->group(function () {
    // Banner Analytics API
    Route::post('/banners/{banner}/impression', [BannerAnalyticsController::class, 'trackImpression']);
    Route::post('/banners/{banner}/click', [BannerAnalyticsController::class, 'trackClick']);
    Route::get('/live-stats', [BannerAnalyticsController::class, 'getLiveStats']);
    Route::get('/recent-purchases', [BannerAnalyticsController::class, 'getRecentPurchases']);
});
