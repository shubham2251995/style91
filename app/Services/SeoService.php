<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SeoService
{
    public function generateTags($model = null)
    {
        // Gracefully handle missing tables (during installation)
        try {
            $defaultTitle = \App\Models\SeoSetting::where('key', 'global_title')->value('value') ?? config('app.name', 'Style91') . ' | Premium Streetwear';
            $defaultDesc = \App\Models\SeoSetting::where('key', 'global_description')->value('value') ?? 'Style91 - The ultimate destination for premium streetwear, exclusive drops, and future fashion.';
            $defaultKeywords = \App\Models\SeoSetting::where('key', 'global_keywords')->value('value') ?? 'streetwear, fashion, style91, drops, exclusive, clothing';
        } catch (\Exception $e) {
            // If table doesn't exist (pre-installation), use defaults
            $defaultTitle = config('app.name', 'Style91') . ' | Premium Streetwear';
            $defaultDesc = 'Style91 - The ultimate destination for premium streetwear, exclusive drops, and future fashion.';
            $defaultKeywords = 'streetwear, fashion, style91, drops, exclusive, clothing';
        }

        $tags = [
            'title' => $defaultTitle,
            'description' => $defaultDesc,
            'keywords' => $defaultKeywords,
            'image' => asset('images/og-default.jpg'),
            'url' => url()->current(),
            'type' => 'website',
        ];

        if ($model) {
            if (method_exists($model, 'getSeoTitle')) {
                $tags['title'] = $model->getSeoTitle();
            } elseif (isset($model->name)) {
                $tags['title'] = $model->name . ' | Style91';
            }

            if (method_exists($model, 'getSeoDescription')) {
                $tags['description'] = $model->getSeoDescription();
            } elseif (isset($model->description)) {
                $tags['description'] = Str::limit(strip_tags($model->description), 160);
            }

            if (isset($model->image_url)) {
                $tags['image'] = $model->image_url;
            }
            
            $tags['type'] = 'article';
        }

        return $tags;
    }

    public function generateSchema($model = null)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Style91',
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
        ];

        if ($model && class_basename($model) === 'Product') {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $model->name,
                'description' => Str::limit(strip_tags($model->description), 160),
                'image' => $model->image_url,
                'sku' => $model->id,
                'offers' => [
                    '@type' => 'Offer',
                    'url' => url()->current(),
                    'priceCurrency' => 'INR',
                    'price' => $model->price * 80, // Assuming price is in USD, converting to INR for display
                    'availability' => $model->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ],
            ];
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
