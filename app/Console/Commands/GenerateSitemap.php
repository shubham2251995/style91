<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the XML sitemap for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $baseUrl = config('app.url');
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Static Pages
        $staticPages = [
            '/',
            '/about',
            '/contact',
            '/terms',
            '/privacy',
            '/returns',
            '/shipping',
            '/careers',
            '/track-order',
            '/gift-cards',
        ];

        foreach ($staticPages as $page) {
            $sitemap .= '    <url>' . PHP_EOL;
            $sitemap .= '        <loc>' . $baseUrl . $page . '</loc>' . PHP_EOL;
            $sitemap .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . PHP_EOL;
            $sitemap .= '        <changefreq>weekly</changefreq>' . PHP_EOL;
            $sitemap .= '        <priority>0.8</priority>' . PHP_EOL;
            $sitemap .= '    </url>' . PHP_EOL;
        }

        // Products
        $products = Product::all();
        foreach ($products as $product) {
            $sitemap .= '    <url>' . PHP_EOL;
            $sitemap .= '        <loc>' . $baseUrl . '/product/' . $product->slug . '</loc>' . PHP_EOL;
            $sitemap .= '        <lastmod>' . $product->updated_at->format('Y-m-d') . '</lastmod>' . PHP_EOL;
            $sitemap .= '        <changefreq>daily</changefreq>' . PHP_EOL;
            $sitemap .= '        <priority>1.0</priority>' . PHP_EOL;
            $sitemap .= '    </url>' . PHP_EOL;
        }

        $sitemap .= '</urlset>';

        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
