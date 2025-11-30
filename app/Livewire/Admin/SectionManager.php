<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Livewire\WithFileUploads;

class SectionManager extends Component
{
    use WithFileUploads;

    public $sections;
    public $editingSectionId = null;
    public $showModal = false;

    // Form fields
    public $type = 'hero';
    public $title;
    public $subtitle;
    public $content;
    public $image_url;
    public $link_url;
    public $link_text;
    public $order = 0;
    public $is_active = true;
    public $newImage;
    
    // Sales-centric fields
    public $products = [];
    public $selectedProducts = [];
    public $selectedCategory = null;
    public $selectedCoupon = null;
    public $show_countdown = false;
    public $countdown_date;
    public $badge_text;
    public $button_style = 'primary';
    public $grid_columns = 4;
    public $auto_populate = false;

    // Available section types with descriptions
    public $sectionTypes = [
        'hero' => '🎬 Hero Banner - Large banner with CTA',
        'flash_sale' => '⚡ Flash Sale - Products with countdown',
        'featured_collection' => '⭐ Featured Collection - Product grid',
        'deal_of_day' => '🔥 Deal of the Day - Single product spotlight',
        'trending' => '📈 Trending Products - Auto or manual',
        'category_showcase' => '📂 Category Cards - Shop by category',
        'limited_stock' => '⚠️ Limited Stock Alert - Low inventory items',
        'coupon_banner' => '🎟️ Coupon Highlight - Promo codes',
        'testimonials' => '💬 Social Proof - Reviews & trust',
        'newsletter' => '📧 Newsletter Signup - Email collection',
    ];

    public function mount()
    {
        $this->refreshSections();
        $this->products = Product::where('is_active', true)->get();
    }

    public function refreshSections()
    {
        $this->sections = HomepageSection::orderBy('order')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->editingSectionId = null;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $section = HomepageSection::find($id);
        $this->editingSectionId = $section->id;
        $this->type = $section->type;
        $this->title = $section->title;
        $this->subtitle = $section->subtitle;
        $this->content = $section->content;
        $this->image_url = $section->image_url;
        $this->link_url = $section->link_url;
        $this->link_text = $section->link_text;
        $this->order = $section->order;
        $this->is_active = $section->is_active;
        
        // Sales-centric fields
        $settings = $section->settings ?? [];
        $this->selectedProducts = $settings['products'] ?? [];
        $this->selectedCategory = $settings['category'] ?? null;
        $this->selectedCoupon = $settings['coupon'] ?? null;
        $this->show_countdown = $settings['show_countdown'] ?? false;
        $this->countdown_date = $settings['countdown_date'] ?? null;
        $this->badge_text = $settings['badge_text'] ?? null;
        $this->button_style = $settings['button_style'] ?? 'primary';
        $this->grid_columns = $settings['grid_columns'] ?? 4;
        $this->auto_populate = $settings['auto_populate'] ?? false;
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'order' => 'integer',
        ]);

        $data = [
            'type' => $this->type,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'link_url' => $this->link_url,
            'link_text' => $this->link_text,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'settings' => [
                'products' => $this->selectedProducts,
                'category' => $this->selectedCategory,
                'coupon' => $this->selectedCoupon,
                'show_countdown' => $this->show_countdown,
                'countdown_date' => $this->countdown_date,
                'badge_text' => $this->badge_text,
                'button_style' => $this->button_style,
                'grid_columns' => $this->grid_columns,
                'auto_populate' => $this->auto_populate,
            ],
        ];

        if ($this->newImage) {
            $path = $this->newImage->store('sections', 'public');
            $data['image_url'] = '/storage/' . $path;
        } elseif (!$this->editingSectionId && !$this->image_url) {
             $data['image_url'] = '/images/placeholder.jpg';
        }

        if ($this->editingSectionId) {
            HomepageSection::find($this->editingSectionId)->update($data);
            session()->flash('message', 'Section updated successfully!');
        } else {
            HomepageSection::create($data);
            session()->flash('message', 'Section created successfully!');
        }

        $this->resetForm();
        $this->refreshSections();
        $this->showModal = false;
    }

    public function delete($id)
    {
        HomepageSection::find($id)->delete();
        $this->refreshSections();
        session()->flash('message', 'Section deleted successfully!');
    }

    public function toggleActive($id)
    {
        $section = HomepageSection::find($id);
        $section->update(['is_active' => !$section->is_active]);
        $this->refreshSections();
    }
    
    public function updateOrder($list)
    {
        foreach ($list as $item) {
            HomepageSection::find($item['value'])->update(['order' => $item['order']]);
        }
        $this->refreshSections();
    }

    public function resetForm()
    {
        $this->editingSectionId = null;
        $this->type = 'hero';
        $this->title = '';
        $this->subtitle = '';
        $this->content = '';
        $this->image_url = '';
        $this->link_url = '';
        $this->link_text = '';
        $this->order = HomepageSection::max('order') + 1;
        $this->is_active = true;
        $this->newImage = null;
        $this->selectedProducts = [];
        $this->selectedCategory = null;
        $this->selectedCoupon = null;
        $this->show_countdown = false;
        $this->countdown_date = null;
        $this->badge_text = null;
        $this->button_style = 'primary';
        $this->grid_columns = 4;
        $this->auto_populate = false;
    }

    public function render()
    {
        $categories = Category::all();
        $coupons = Coupon::where('is_active', true)
                        ->where('expires_at', '>', now())
                        ->get();

        return view('livewire.admin.section-manager', [
            'categories' => $categories,
            'coupons' => $coupons,
        ])->layout('components.layouts.admin');
    }
}
