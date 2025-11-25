<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Home;
use App\Livewire\ProductShow;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Http\Controllers\PageController;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\PluginManager as AdminPluginManager;
use App\Livewire\Admin\GodView;
use App\Livewire\Admin\PriceTiers;

use App\Livewire\Cart;
use App\Livewire\Checkout;

use App\Livewire\FlexCard;

use App\Livewire\Wardrobe\Index as WardrobeIndex;
use App\Livewire\MysteryBox\Index as MysteryBoxIndex;
use App\Livewire\MysteryBox\Show as MysteryBoxShow;
use App\Livewire\BulkOrder;
use App\Livewire\Quote\Request as QuoteRequest;
use App\Livewire\StreetwearTV\Index as TVIndex;
use App\Livewire\StreetwearTV\Show as TVShow;
use App\Livewire\Editorial\Index as EditorialIndex;
use App\Livewire\Editorial\Show as EditorialShow;

Route::get('/', Home::class)->name('home');
Route::get('/search', \App\Livewire\ProductSearch::class)->name('search');
Route::get('/new-arrivals', \App\Livewire\NewArrivals::class)->name('new-arrivals');
Route::get('/sale', \App\Livewire\SalePage::class)->name('sale');
Route::get('/size-guide', \App\Livewire\SizeGuide::class)->name('size-guide');
Route::get('/product/{slug}', ProductShow::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/flex/{orderId}', FlexCard::class)->name('flex');
Route::get('/wardrobe', WardrobeIndex::class)->name('wardrobe')->middleware('auth');
Route::get('/wishlist', \App\Livewire\WishlistIndex::class)->name('wishlist')->middleware('auth');
Route::get('/account', \App\Livewire\CustomerDashboard::class)->name('account')->middleware('auth');
Route::get('/gift-cards', \App\Livewire\GiftCardPurchase::class)->name('gift-cards.purchase');
Route::get('/track-order', \App\Livewire\OrderTracking::class)->name('track-order');
Route::get('/mystery-boxes', MysteryBoxIndex::class)->name('mystery-box.index');
Route::get('/mystery-box/{slug}', MysteryBoxShow::class)->name('mystery-box.show');
Route::get('/bulk-order', BulkOrder::class)->name('bulk-order');
Route::get('/quote/request', QuoteRequest::class)->name('quote.request')->middleware('auth');
Route::get('/tv', TVIndex::class)->name('tv.index');
Route::get('/tv/{slug}', TVShow::class)->name('tv.show');
Route::get('/editorial', EditorialIndex::class)->name('editorial.index');
Route::get('/editorial/{slug}', EditorialShow::class)->name('editorial.show');

Route::get('/fit-check', \App\Livewire\FitCheck\Gallery::class)->name('fit-check.gallery');
Route::get('/fit-check/upload', \App\Livewire\FitCheck\Upload::class)->name('fit-check.upload')->middleware('auth');

Route::get('/lookbook', \App\Livewire\Lookbook\Index::class)->name('lookbook.index');
Route::get('/swipe', \App\Livewire\SwipeToCop::class)->name('swipe');
Route::get('/stylist', \App\Livewire\AiStylist::class)->name('stylist');
Route::get('/vault', \App\Livewire\TheVault::class)->name('vault');

Route::get('/remix', \App\Livewire\RemixStudio::class)->name('remix');
Route::get('/radar', \App\Livewire\DropRadar::class)->name('radar');
Route::get('/resell', \App\Livewire\ResellMarket::class)->name('resell');

// Future Tech (Public)
Route::get('/token-gate', \App\Livewire\TokenGate::class)->name('token-gate');
Route::get('/vote', \App\Livewire\VoteToMake::class)->name('vote');
Route::get('/mirror', \App\Livewire\MagicMirror::class)->name('magic-mirror');
Route::get('/customizer', \App\Livewire\Customizer::class)->name('customizer');

// SEO
Route::get('/sitemap.xml', function() {
    $products = \App\Models\Product::all();
    $categories = \App\Models\Product::distinct()->pluck('category')->filter();
    return response()->view('sitemap', compact('products', 'categories'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/install', \App\Livewire\Installer::class)->name('install');

Route::get('/login', \App\Livewire\Auth\MobileLogin::class)->name('login');
Route::get('/register', \App\Livewire\Auth\MobileLogin::class)->name('register');
Route::get('/admin/login', \App\Livewire\Auth\AdminLogin::class)->name('admin.login');
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    return 'Cache Cleared! <a href="/">Go Home</a>';
});

Route::get('/system/migrate', function() {
    // Protect with APP_KEY to prevent unauthorized access
    if (request('key') !== config('app.key')) {
        abort(403, 'Unauthorized. Please provide the correct APP_KEY as the "key" query parameter.');
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return '<pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre><br>Migrations Completed! <a href="/">Go Home</a>';
    } catch (\Exception $e) {
        return 'Migration Failed: ' . $e->getMessage();
    }
});

Route::get('/debug-auth', function () {
    return [
        'is_logged_in' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'app_env' => config('app.env'),
        'app_url' => config('app.url'),
    ];
});

// Influencer (Public/Auth)
Route::get('/ambassador/join', \App\Livewire\Influencer\Register::class)->name('influencer.register');
Route::get('/ambassador/dashboard', \App\Livewire\Influencer\Dashboard::class)->name('influencer.dashboard')->middleware('auth');

// The Style Club (Membership)
Route::get('/club', \App\Livewire\Membership\Dashboard::class)->name('club.dashboard')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/plugins', AdminPluginManager::class)->name('plugins');
    Route::get('/god-view', GodView::class)->name('god-view');
    Route::get('/price-tiers', PriceTiers::class)->name('price-tiers');
    Route::get('/custom-branding', \App\Livewire\Admin\CustomBranding::class)->name('custom-branding');
    Route::get('/tiers', \App\Livewire\Admin\TierManager::class)->name('tier-manager');
    
    // The Eye (Analytics)
    Route::get('/session-logger', \App\Livewire\Admin\SessionLogger::class)->name('session-logger');
    Route::get('/heatmap', \App\Livewire\Admin\HeatmapTracker::class)->name('heatmap');
    Route::get('/journey', \App\Livewire\Admin\JourneyMap::class)->name('journey-map');
    Route::get('/funnel', \App\Livewire\Admin\FunnelDoctor::class)->name('funnel-doctor');
    Route::get('/channels', \App\Livewire\Admin\ChannelVision::class)->name('channel-vision');

    // The Ledger (Finance)
    Route::get('/profit-pilot', \App\Livewire\Admin\ProfitPilot::class)->name('profit-pilot');
    Route::get('/fraud-detection', \App\Livewire\Admin\FraudDetection::class)->name('fraud-detection');
    Route::get('/stock', \App\Livewire\Admin\StockProphet::class)->name('stock-prophet');
    Route::get('/deadstock', \App\Livewire\Admin\DeadStockReaper::class)->name('dead-stock-reaper');
    Route::get('/treasury', \App\Livewire\Admin\Treasury::class)->name('treasury');

    // The Architect & Command
    Route::get('/config', \App\Livewire\Admin\ConfigEngine::class)->name('config-engine');
    Route::get('/oracle', \App\Livewire\Admin\TheOracle::class)->name('the-oracle');
    Route::get('/mission-control', \App\Livewire\Admin\MissionControl::class)->name('mission-control');
    Route::get('/mobile', \App\Livewire\Admin\MobileCommander::class)->name('mobile-commander');
    Route::get('/actions', \App\Livewire\Admin\ActionCenter::class)->name('action-center');
    
    // The Lab & Grid
    Route::get('/pod', \App\Livewire\Admin\PodApi::class)->name('pod-api');
    Route::get('/pos', \App\Livewire\Admin\PopupPos::class)->name('popup-pos');
    Route::get('/seo', \App\Livewire\Admin\SeoManager::class)->name('seo-manager');
    Route::get('/influencers', \App\Livewire\Admin\InfluencerManager::class)->name('influencer-manager');
    Route::get('/payments', \App\Livewire\Admin\PaymentManager::class)->name('payment-manager');
    Route::get('/settings', \App\Livewire\Admin\SettingsManager::class)->name('settings-manager');
    Route::get('/site-settings', \App\Livewire\Admin\SiteSettings::class)->name('site-settings');
    Route::get('/header-footer', \App\Livewire\Admin\HeaderFooterManager::class)->name('header-footer');
    Route::get('/pages', \App\Livewire\Admin\PageManager::class)->name('page-manager');
    Route::get('/sections', \App\Livewire\Admin\SectionManager::class)->name('section-manager');
});

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

// Static Pages
Route::controller(PageController::class)->group(function () {
    Route::get('/about', 'show')->defaults('page', 'about')->name('about');
    Route::get('/contact', 'show')->defaults('page', 'contact')->name('contact');
    Route::get('/terms', 'show')->defaults('page', 'terms')->name('terms');
    Route::get('/privacy', 'show')->defaults('page', 'privacy')->name('privacy');
    Route::get('/returns', 'show')->defaults('page', 'returns')->name('returns');
    Route::get('/shipping', 'show')->defaults('page', 'shipping')->name('shipping');
    Route::get('/careers', 'show')->defaults('page', 'careers')->name('careers');
    Route::get('/track-order', 'show')->defaults('page', 'track-order')->name('track-order');
    Route::get('/gift-cards', 'show')->defaults('page', 'gift-cards')->name('gift-cards');
});
