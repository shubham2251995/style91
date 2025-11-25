<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
    public function show($page)
    {
        $pageModel = Page::where('slug', $page)->where('is_active', true)->first();

        if (!$pageModel) {
            // Fallback for hardcoded pages if DB is empty or migration not run
            $titles = [
                'about' => 'About Us',
                'contact' => 'Contact Us',
                'terms' => 'Terms of Service',
                'privacy' => 'Privacy Policy',
                'returns' => 'Returns & Exchanges',
                'shipping' => 'Shipping Information',
                'careers' => 'Careers',
                'track-order' => 'Track Your Order',
                'gift-cards' => 'Gift Cards',
            ];

            if (!array_key_exists($page, $titles)) {
                abort(404);
            }

            $title = $titles[$page];
            $content = null;
        } else {
            $title = $pageModel->title;
            $content = $pageModel->content;
            
            // Set SEO tags if available
            if ($pageModel->meta_title) {
                // This would typically be handled by a layout or view composer, 
                // but for now we pass it to the view or let the view handle it.
            }
        }

        return view('pages.default', compact('title', 'page', 'content'));
    }
}
