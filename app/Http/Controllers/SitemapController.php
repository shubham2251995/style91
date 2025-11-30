<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // Get all active products with updated_at
        $products = Product::where('is_active', true)
                          ->select('slug', 'updated_at')
                          ->get();

        // Get all categories
        $categories = Category::select('slug', 'updated_at')->get();

        // Define static pages with priorities
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('cart.index'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => route('profile'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('login'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('register'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        // Add optional pages if they exist
        $optionalRoutes = ['about', 'contact', 'terms', 'privacy', 'shipping', 'returns'];
        foreach ($optionalRoutes as $routeName) {
            if (\Route::has($routeName)) {
                $staticPages[] = [
                    'url' => route($routeName),
                    'priority' => '0.5',
                    'changefreq' => 'monthly'
                ];
            }
        }

        $content = view('sitemap', compact('products', 'categories', 'staticPages'));

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
