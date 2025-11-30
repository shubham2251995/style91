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
        $this->info('Generating comprehensive sitemap...');

        $baseUrl = rtrim(config('app.url'), '/');
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . PHP_EOL;
        $sitemap .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;

        // Homepage - Highest Priority
        $sitemap .= $this->createUrl($baseUrl . '/', now()->format('Y-m-d'), 'daily', '1.0');

        // Main Category Pages
        $mainPages = [
            '/products' => ['daily', '0.9'],
            '/cart' => ['weekly', '0.7'],
            '/profile' => ['monthly', '0.6'],
        ];

        foreach ($mainPages as $path => $config) {
            $sitemap .= $this->createUrl($baseUrl . $path, now()->format('Y-m-d'), $config[0], $config[1]);
        }

        // Static Pages
        $staticPages = [
            '/about', '/contact', '/terms', '/privacy',
            '/returns', '/shipping', '/careers', '/track-order'
        ];

        foreach ($staticPages as $page) {
            $sitemap .= $this->createUrl($baseUrl . $page, now()->format('Y-m-d'), 'monthly', '0.5');
        }

        // Categories
        $this->info('Adding categories...');
        $categories = \App\Models\Category::select('slug', 'updated_at')->get();
        foreach ($categories as $category) {
            $sitemap .= $this->createUrl(
                $baseUrl . '/category/' . $category->slug,
                $category->updated_at->format('Y-m-d'),
                'weekly',
                '0.8'
            );
        }

        // Products - Highest Priority
        $this->info('Adding products...');
        $products = \App\Models\Product::where('is_active', true)
                                      ->select('slug', 'updated_at')
                                      ->get();
                                      
        $bar = $this->output->createProgressBar(count($products));
        $bar->start();

        foreach ($products as $product) {
            $sitemap .= $this->createUrl(
                $baseUrl . '/product/' . $product->slug,
                $product->updated_at->format('Y-m-d'),
                'daily',
                '1.0'
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $sitemap .= '</urlset>';

        \File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('✓ Sitemap generated successfully!');
        $this->info('  Location: public/sitemap.xml');
        $this->info('  Total URLs: ' . (count($mainPages) + count($staticPages) + count($categories) + count($products) + 1));
        $this->newLine();
        $this->comment('Submit to Google: https://search.google.com/search-console');
        
        return 0;
    }

    private function createUrl($loc, $lastmod, $changefreq, $priority)
    {
        $xml = '    <url>' . PHP_EOL;
        $xml .= '        <loc>' . htmlspecialchars($loc) . '</loc>' . PHP_EOL;
        $xml .= '        <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        $xml .= '        <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
        $xml .= '        <priority>' . $priority . '</priority>' . PHP_EOL;
        $xml .= '    </url>' . PHP_EOL;
        return $xml;
    }
}
