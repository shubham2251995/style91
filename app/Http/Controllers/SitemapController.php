<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $pages = [
            'home', 'lookbook.index', 'wardrobe', 'login', 'register'
        ];

        $content = view('sitemap', compact('products', 'pages'));

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
