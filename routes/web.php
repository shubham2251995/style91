<?php

use Illuminate\Support\Facades\Route;

// Installer Routes
Route::controller(App\Http\Controllers\InstallerController::class)->prefix('install')->group(function () {
    Route::get('/', 'index')->name('install.index');
    Route::get('/requirements', 'checkRequirements')->name('install.requirements');
    Route::post('/test-db', 'testDatabase')->name('install.test-db');
    Route::post('/run', 'install')->name('install.run');
    Route::post('/create-admin', 'createAdmin')->name('install.create-admin');
});

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

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);
Route::get('/robots.txt', function() {
    return response()->view('robots')->header('Content-Type', 'text/plain');
});
Route::get('/checkout/address', \App\Livewire\Checkout\CheckoutAddress::class)->name('checkout.address');
Route::get('/checkout/payment', \App\Livewire\Checkout\CheckoutPayment::class)->name('checkout.payment');
Route::any('/payment/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/search', \App\Livewire\ProductSearch::class)->name('search');
Route::get('/new-arrivals', \App\Livewire\NewArrivals::class)->name('new-arrivals');
Route::get('/sale', \App\Livewire\SalePage::class)->name('sale');
Route::get('/size-guide', \App\Livewire\SizeGuide::class)->name('size-guide');
Route::get('/product/{slug}', ProductShow::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', function() {
    return redirect()->route('checkout.address');
})->name('checkout');

// Onboarding & Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', \App\Livewire\Onboarding\OnboardingWizard::class)->name('onboarding');
    Route::get('/profile', \App\Livewire\UserProfile::class)->name('profile');
    Route::get('/account', \App\Livewire\CustomerDashboard::class)->name('account');
});

// Authentication Routes::get('/flex/{orderId}', FlexCard::class)->name('flex');
Route::get('/flex/{orderId}', FlexCard::class)->name('flex');
Route::get('/wardrobe', WardrobeIndex::class)->name('wardrobe')->middleware('auth');
Route::get('/wishlist', \App\Livewire\WishlistIndex::class)->name('wishlist')->middleware('auth');
Route::get('/account/orders/{orderId}', \App\Livewire\OrderDetails::class)->name('account.order')->middleware('auth');
Route::get('/account/orders/{orderId}/return', \App\Livewire\ReturnRequestPage::class)->name('account.order.return')->middleware('auth');
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

// Plugin Routes
Route::middleware(['web'])->group(function () {
    // AI Stylist
    Route::get('/stylist', App\Livewire\AiStylist::class)->name('plugin.stylist');
    
    // Fit Check
    Route::get('/fit-check', App\Livewire\FitCheck\Gallery::class)->name('plugin.fit-check');
    Route::get('/fit-check/upload', App\Livewire\FitCheck\Upload::class)->name('plugin.fit-check.upload');
    
    // Mystery Box
    Route::get('/mystery-box', App\Livewire\MysteryBox\Index::class)->name('plugin.mystery-box');
    
    // Raffles
    Route::get('/raffle', App\Livewire\Raffle\Index::class)->name('plugin.raffle');
    
    // Streetwear TV
    Route::get('/tv', App\Livewire\StreetwearTV\Index::class)->name('plugin.streetwear-tv');
    
    // Lookbook
    Route::get('/lookbook', App\Livewire\Lookbook\Index::class)->name('plugin.lookbook');
    
    // Vote to Make
    Route::get('/vote', App\Livewire\VoteToMake::class)->name('plugin.vote');
    
    // Resell Market
    Route::get('/resell', App\Livewire\ResellMarket::class)->name('plugin.resell');
    
    // Social Unlock
    Route::get('/social-unlock', App\Livewire\SocialUnlock::class)->name('plugin.social-unlock');
});

Route::get('/swipe', \App\Livewire\SwipeToCop::class)->name('swipe');
Route::get('/vault', \App\Livewire\TheVault::class)->name('vault');

Route::get('/remix', \App\Livewire\RemixStudio::class)->name('remix');
Route::get('/radar', \App\Livewire\DropRadar::class)->name('radar');

// Future Tech (Public)
Route::get('/token-gate', \App\Livewire\TokenGate::class)->name('token-gate');
Route::get('/mirror', \App\Livewire\MagicMirror::class)->name('magic-mirror');
Route::get('/customizer', \App\Livewire\Customizer::class)->name('customizer');

// Lookbook
Route::get('/lookbook', \App\Livewire\Lookbook\Index::class)->name('lookbook.index');
Route::get('/lookbook/{lookbook}', \App\Livewire\Lookbook\Show::class)->name('lookbook.show');

// SEO
// Sitemap route moved to controller below

// OLD Livewire installer (disabled - using standalone controller instead)
// Route::get('/install', \App\Livewire\Installer::class)->name('install');

Route::get('/login', \App\Livewire\Auth\MobileLogin::class)->name('login');
Route::get('/register', \App\Livewire\Auth\MobileLogin::class)->name('register');
Route::get('/admin/login', \App\Livewire\Auth\AdminLogin::class)->name('admin.login');
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// Routes removed for production security
// Use SSH or Artisan commands for cache clearing and migrations

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

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/plugins', AdminPluginManager::class)->name('plugins');
    Route::get('/plugins/{key}/edit', \App\Livewire\Admin\PluginEditor::class)->name('admin.plugin.edit');
    Route::get('/god-view', GodView::class)->name('god-view');
    Route::get('/price-tiers', PriceTiers::class)->name('price-tiers');
    Route::get('/theme-manager', \App\Livewire\Admin\ThemeManager::class)->name('theme-manager');
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
    Route::get('/orders', \App\Livewire\Admin\OrderManager::class)->name('order-manager');
    Route::get('/coupons', \App\Livewire\Admin\CouponManager::class)->name('coupon-manager');
    Route::get('/shipping', \App\Livewire\Admin\ShippingManager::class)->name('shipping-manager');
    Route::get('/payment-gateways', \App\Livewire\Admin\PaymentGatewayManager::class)->name('payment-gateway-manager');
    Route::get('/size-guides', \App\Livewire\Admin\SizeGuideManager::class)->name('size-guide-manager');
    Route::get('/products', \App\Livewire\Admin\ProductManager::class)->name('product-manager');
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('category-manager');
    Route::get('/tags', \App\Livewire\Admin\TagManager::class)->name('tag-manager');
    Route::get('/reviews', \App\Livewire\Admin\ReviewManager::class)->name('review-manager');
    Route::get('/inventory', \App\Livewire\Admin\InventoryManager::class)->name('inventory-manager');
    Route::get('/customers', \App\Livewire\Admin\CustomerManager::class)->name('customer-manager');
    Route::get('/users', \App\Livewire\Admin\UserManager::class)->name('user-manager');
    Route::get('/variants', \App\Livewire\Admin\VariantManager::class)->name('variant-manager');
    Route::get('/bundles', \App\Livewire\Admin\BundleManager::class)->name('bundle-manager');
    Route::get('/returns', \App\Livewire\Admin\ReturnManager::class)->name('return-manager');
    Route::get('/abandoned-carts', \App\Livewire\Admin\AbandonedCartManager::class)->name('abandoned-cart-manager');
    Route::get('/loyalty', \App\Livewire\Admin\LoyaltyManager::class)->name('loyalty-manager');
    Route::get('/flash-sales', \App\Livewire\Admin\FlashSaleManager::class)->name('flash-sale-manager');
    Route::get('/newsletter', \App\Livewire\Admin\NewsletterManager::class)->name('newsletter-manager');
    Route::get('/analytics', \App\Livewire\Admin\SalesDashboard::class)->name('sales-dashboard');
    Route::get('/reports', \App\Livewire\Admin\ReportManager::class)->name('report-manager');
    Route::get('/sections', \App\Livewire\Admin\SectionManager::class)->name('section-manager');
    Route::get('/banners', \App\Livewire\Admin\BannerManager::class)->name('banner-manager');
    Route::get('/menus', \App\Livewire\Admin\MenuManager::class)->name('menu-manager');
    Route::get('/stock-adjustments', \App\Livewire\Admin\StockAdjustmentManager::class)->name('stock-adjustments');
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
});
