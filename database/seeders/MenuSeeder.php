<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Header Menu
        $header = Menu::firstOrCreate(
            ['slug' => 'header'],
            ['name' => 'Main Header', 'location' => 'header']
        );

        if ($header->items()->count() == 0) {
            $this->createItem($header->id, 'New Arrivals', null, 'new-arrivals');
            $this->createItem($header->id, 'Sale', null, 'sale');
            $this->createItem($header->id, 'Mystery Boxes', null, 'mystery-box.index');
            $this->createItem($header->id, 'Streetwear TV', null, 'tv.index');
            $this->createItem($header->id, 'Editorial', null, 'editorial.index');
        }

        // Footer Menu 1 (Shop)
        $footer1 = Menu::firstOrCreate(
            ['slug' => 'footer-shop'],
            ['name' => 'Shop', 'location' => 'footer_1']
        );

        if ($footer1->items()->count() == 0) {
            $this->createItem($footer1->id, 'New Arrivals', null, 'new-arrivals');
            $this->createItem($footer1->id, 'Best Sellers', '/best-sellers'); // URL example
            $this->createItem($footer1->id, 'Sale', null, 'sale');
            $this->createItem($footer1->id, 'Gift Cards', null, 'gift-cards.purchase');
        }

        // Footer Menu 2 (Company)
        $footer2 = Menu::firstOrCreate(
            ['slug' => 'footer-company'],
            ['name' => 'Company', 'location' => 'footer_2']
        );

        if ($footer2->items()->count() == 0) {
            $this->createItem($footer2->id, 'About Us', null, 'about');
            $this->createItem($footer2->id, 'Careers', null, 'careers');
            $this->createItem($footer2->id, 'Terms & Conditions', null, 'terms');
            $this->createItem($footer2->id, 'Privacy Policy', null, 'privacy');
        }
    }

    private function createItem($menuId, $title, $url = null, $route = null, $parentId = null)
    {
        MenuItem::create([
            'menu_id' => $menuId,
            'title' => $title,
            'url' => $url,
            'route' => $route,
            'parent_id' => $parentId,
        ]);
    }
}
