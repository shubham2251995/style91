<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Banner;
use App\Models\DropNotification;

/*
|--------------------------------------------------------------------------
| API Routes for Banner Analytics
|--------------------------------------------------------------------------
*/

// Track banner impression
Route::post('/banners/{banner}/impression', function (Banner $banner) {
    $banner->incrementImpressions();
    return response()->json(['success' => true]);
});

// Track banner click
Route::post('/banners/{banner}/click', function (Banner $banner) {
    $banner->incrementClicks();
    return response()->json(['success' => true]);
});

// Track video play
Route::post('/banners/{banner}/video-play', function (Request $request, Banner $banner) {
    $watchTime = $request->input('watch_time', 0);
    $banner->trackVideoPlay($watchTime);
    return response()->json(['success' => true]);
});

// Drop notification signup
Route::post('/drops/{banner}/notify', function (Request $request, Banner $banner) {
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'nullable|string|max:100',
        'phone' => 'nullable|string|max:20',
    ]);

    // Check if already subscribed
    $existing = DropNotification::where('banner_id', $banner->id)
        ->where('user_email', $validated['email'])
        ->first();

    if ($existing) {
        return response()->json([
            'success' => true,
            'message' => 'You are already on the notification list!'
        ]);
    }

    DropNotification::create([
        'banner_id' => $banner->id,
        'user_email' => $validated['email'],
        'user_name' => $validated['name'] ?? null,
        'user_phone' => $validated['phone'] ?? null,
    ]);

    // Update analytics
    $today = now()->toDateString();
    $analytic = $banner->analytics()->firstOrCreate(
        ['date' => $today],
        ['drop_notifications' => 0]
    );
    $analytic->increment('drop_notifications');

    return response()->json([
        'success' => true,
        'message' => 'You will be notified when this drops!'
    ]);
});

// Share tracking
Route::post('/banners/{banner}/share', function (Request $request, Banner $banner) {
    $platform = $request->input('platform', 'unknown');
    
    $today = now()->toDateString();
    $analytic = $banner->analytics()->firstOrCreate(
        ['date' => $today],
        ['shares' => 0]
    );
    $analytic->increment('shares');

    return response()->json(['success' => true]);
});
