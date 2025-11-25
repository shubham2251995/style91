<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public function getHeader()
    {
        try {
            return Cache::remember('navigation_header', 3600, function () {
                $config = SystemConfiguration::where('key', 'header_links')->first();
                
                if ($config && $config->value) {
                    return json_decode($config->value, true);
                }

                return $this->getDefaultHeader();
            });
        } catch (\Exception $e) {
            return $this->getDefaultHeader();
        }
    }

    private function getDefaultHeader()
    {
        return [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'New Arrivals', 'url' => route('new-arrivals')],
           ['label' => 'Sale', 'url' => route('sale')],
            ['label' => 'Explore', 'url' => route('lookbook.index')],
            ['label' => 'Wardrobe', 'url' => route('wardrobe')],
        ];
    }

    public function getFooter()
    {
        try {
            return Cache::remember('navigation_footer', 3600, function () {
                $config = SystemConfiguration::where('key', 'footer_columns')->first();
                
                if ($config && $config->value) {
                    return json_decode($config->value, true);
                }

                return $this->getDefaultFooter();
            });
        } catch (\Exception $e) {
            return $this->getDefaultFooter();
        }
    }

    private function getDefaultFooter()
    {
        return [
            [
                'title' => 'Shop',
                'links' => [
                    ['label' => 'New Arrivals', 'url' => route('lookbook.index')],
                    ['label' => 'Bestsellers', 'url' => route('lookbook.index')],
                    ['label' => 'Sale', 'url' => route('lookbook.index')],
                    ['label' => 'Gift Cards', 'url' => route('gift-cards')],
                ]
            ],
            [
                'title' => 'Support',
                'links' => [
                    ['label' => 'Contact Us', 'url' => route('contact')],
                    ['label' => 'Track Order', 'url' => route('track-order')],
                    ['label' => 'Returns', 'url' => route('returns')],
                    ['label' => 'Shipping Info', 'url' => route('shipping')],
                ]
            ],
            [
                'title' => 'Company',
                'links' => [
                    ['label' => 'About Us', 'url' => route('about')],
                    ['label' => 'Careers', 'url' => route('careers')],
                    ['label' => 'Privacy Policy', 'url' => route('privacy')],
                    ['label' => 'Terms of Service', 'url' => route('terms')],
                ]
            ]
        ];
    }

    public function getSocials()
    {
        try {
            return Cache::remember('navigation_socials', 3600, function () {
                $config = SystemConfiguration::where('key', 'social_links')->first();
                
                if ($config && $config->value) {
                    return json_decode($config->value, true);
                }

                return [];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    public function clearCache()
    {
        Cache::forget('navigation_header');
        Cache::forget('navigation_footer');
        Cache::forget('navigation_socials');
    }
}
