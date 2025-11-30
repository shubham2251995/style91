<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\HomepageSection;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public function render()
    {
        try {
            $sections = HomepageSection::active()
                ->ordered()
                ->get()
                ->filter(function ($section) {
                    $device = request()->userAgent() && strpos(request()->userAgent(), 'Mobile') !== false ? 'mobile' : 'desktop';
                    return $section->isVisibleFor(auth()->user(), $device);
                })
                ->map(function ($section) {
                    // Enrich sections with data based on type
                    return $this->enrichSection($section);
                });
        } catch (\Exception $e) {
            Log::error('Error loading homepage sections: ' . $e->getMessage());
            $sections = collect([]);
        }

        try {
            $activeFlashSales = FlashSale::where('is_active', true)
                                         ->where('start_time', '<=', now())
                                         ->where('end_time', '>=', now())
                                         ->with('products')
                                         ->get();
        } catch (\Exception $e) {
            Log::error('Error loading flash sales: ' . $e->getMessage());
            $activeFlashSales = collect([]);
        }

        return view('livewire.home', [
            'sections' => $sections,
            'activeFlashSales' => $activeFlashSales,
        ]);
    }

    protected function enrichSection($section)
    {
        $settings = $section->settings ?? [];

        // Add products to section based on type and settings
        switch ($section->type) {
            case 'featured_collection':
            case 'flash_sale':
                if (!empty($settings['products'])) {
                    $section->sectionProducts = Product::whereIn('id', $settings['products'])->get();
                } elseif ($settings['auto_populate'] ?? false) {
                    $section->sectionProducts = Product::where('is_active', true)
                                                       ->latest()
                                                       ->take($settings['grid_columns'] ?? 4)
                                                       ->get();
                }
                break;

            case 'trending':
                if ($settings['auto_populate'] ?? true) {
                    // Get trending products based on order count
                    $section->sectionProducts = Product::select('products.*')
                        ->join('order_items', 'products.id', '=', 'order_items.product_id')
                        ->groupBy('products.id')
                        ->orderByRaw('SUM(order_items.quantity) DESC')
                        ->take($settings['grid_columns'] ?? 4)
                        ->get();
                } else {
                    $section->sectionProducts = Product::whereIn('id', $settings['products'] ?? [])->get();
                }
                break;

            case 'limited_stock':
                // Auto-populate with low stock items
                $section->sectionProducts = Product::where('is_active', true)
                                                   ->where('stock', '>', 0)
                                                   ->where('stock', '<=', 10)
                                                   ->take($settings['grid_columns'] ?? 4)
                                                   ->get();
                break;

            case 'category_showcase':
                if (!empty($settings['category'])) {
                    $section->category = Category::find($settings['category']);
                    $section->sectionProducts = Product::where('category_id', $settings['category'])
                                                       ->where('is_active', true)
                                                       ->take($settings['grid_columns'] ?? 4)
                                                       ->get();
                }
                break;

            case 'deal_of_day':
                if (!empty($settings['products'])) {
                    $section->dealProduct = Product::find($settings['products'][0]);
                }
                break;

            case 'coupon_banner':
                if (!empty($settings['coupon'])) {
                    $section->coupon = Coupon::find($settings['coupon']);
                }
                break;
        }

        return $section;
    }
}
