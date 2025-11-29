<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Banner;
use App\Models\HeroSlide;

class BannerManager extends Component
{
    use WithFileUploads;

    public $banners;
    public $editingBannerId = null;
    public $filterType = 'all';

    // Form fields
    public $type = 'drop';
    public $title;
    public $subtitle;
    public $description;
    public $media_type = 'image';
    public $desktop_media;
    public $mobile_media;
    public $desktop_media_url;
    public $mobile_media_url;
    
    // Video settings
    public $video_autoplay = true;
    public $video_loop = true;
    public $video_muted = true;
    
    // Drop settings
    public $drop_date;
    public $stock_count;
    public $notify_enabled = false;
    
    // Social settings
    public $instagram_hashtag;
    public $tiktok_hashtag;
    public $social_feed_enabled = false;
    
    // Hype settings
    public $show_view_count = false;
    public $show_purchase_ticker = false;
    public $show_stock_ticker = false;
    
    // Styling
    public $text_position = 'center';
    public $overlay_type = 'gradient';
    public $overlay_opacity = 50;
    public $background_color;
    public $text_color;
    public $accent_color;
    
    // Animation
    public $entrance_animation = 'fade';
    public $scroll_effect = 'none';
    
    // CTA
    public $cta_text;
    public $cta_url;
    public $cta_style = 'primary';
    
    // Badge
    public $badge_text;
    public $badge_style = 'new';
    
    // Positioning
    public $position = 'hero';
    public $display_priority = 0;
    
    // Visibility
    public $is_active = true;
    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->refreshBanners();
    }

    public function refreshBanners()
    {
        $query = Banner::query()->with('heroSlides')->ordered();
        
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }
        
        $this->banners = $query->get();
    }

    public function updatedFilterType()
    {
        $this->refreshBanners();
    }

    public function create()
    {
        $this->resetForm();
        $this->editingBannerId = null;
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        
        $this->editingBannerId = $banner->id;
        $this->type = $banner->type;
        $this->title = $banner->title;
        $this->subtitle = $banner->subtitle;
        $this->description = $banner->description;
        $this->media_type = $banner->media_type;
        $this->desktop_media_url = $banner->desktop_media_url;
        $this->mobile_media_url = $banner->mobile_media_url;
        
        $this->video_autoplay = $banner->video_autoplay;
        $this->video_loop = $banner->video_loop;
        $this->video_muted = $banner->video_muted;
        
        $this->drop_date = $banner->drop_date?->format('Y-m-d\TH:i');
        $this->stock_count = $banner->stock_count;
        $this->notify_enabled = $banner->notify_enabled;
        
        $this->instagram_hashtag = $banner->instagram_hashtag;
        $this->tiktok_hashtag = $banner->tiktok_hashtag;
        $this->social_feed_enabled = $banner->social_feed_enabled;
        
        $this->show_view_count = $banner->show_view_count;
        $this->show_purchase_ticker = $banner->show_purchase_ticker;
        $this->show_stock_ticker = $banner->show_stock_ticker;
        
        $this->text_position = $banner->text_position;
        $this->overlay_type = $banner->overlay_type;
        $this->overlay_opacity = $banner->overlay_opacity;
        $this->background_color = $banner->background_color;
        $this->text_color = $banner->text_color;
        $this->accent_color = $banner->accent_color;
        
        $this->entrance_animation = $banner->entrance_animation;
        $this->scroll_effect = $banner->scroll_effect;
        
        $this->cta_text = $banner->cta_text;
        $this->cta_url = $banner->cta_url;
        $this->cta_style = $banner->cta_style;
        
        $this->badge_text = $banner->badge_text;
        $this->badge_style = $banner->badge_style;
        
        $this->position = $banner->position;
        $this->display_priority = $banner->display_priority;
        
        $this->is_active = $banner->is_active;
        $this->start_date = $banner->start_date?->format('Y-m-d\TH:i');
        $this->end_date = $banner->end_date?->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        $data = [
            'type' => $this->type,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'media_type' => $this->media_type,
            'video_autoplay' => $this->video_autoplay,
            'video_loop' => $this->video_loop,
            'video_muted' => $this->video_muted,
            'drop_date' => $this->drop_date,
            'stock_count' => $this->stock_count,
            'notify_enabled' => $this->notify_enabled,
            'instagram_hashtag' => $this->instagram_hashtag,
            'tiktok_hashtag' => $this->tiktok_hashtag,
            'social_feed_enabled' => $this->social_feed_enabled,
            'show_view_count' => $this->show_view_count,
            'show_purchase_ticker' => $this->show_purchase_ticker,
            'show_stock_ticker' => $this->show_stock_ticker,
            'text_position' => $this->text_position,
            'overlay_type' => $this->overlay_type,
            'overlay_opacity' => $this->overlay_opacity,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
            'accent_color' => $this->accent_color,
            'entrance_animation' => $this->entrance_animation,
            'scroll_effect' => $this->scroll_effect,
            'cta_text' => $this->cta_text,
            'cta_url' => $this->cta_url,
            'cta_style' => $this->cta_style,
            'badge_text' => $this->badge_text,
            'badge_style' => $this->badge_style,
            'position' => $this->position,
            'display_priority' => $this->display_priority,
            'is_active' => $this->is_active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        // Handle desktop media upload
        if ($this->desktop_media) {
            $path = $this->desktop_media->store('banners', 'public');
            $data['desktop_media_url'] = '/storage/' . $path;
        }

        // Handle mobile media upload
        if ($this->mobile_media) {
            $path = $this->mobile_media->store('banners', 'public');
            $data['mobile_media_url'] = '/storage/' . $path;
        }

        if ($this->editingBannerId) {
            Banner::find($this->editingBannerId)->update($data);
            session()->flash('message', 'Banner updated successfully!');
        } else {
            Banner::create($data);
            session()->flash('message', 'Banner created successfully!');
        }

        $this->resetForm();
        $this->refreshBanners();
    }

    public function delete($id)
    {
        Banner::find($id)->delete();
        $this->refreshBanners();
        session()->flash('message', 'Banner deleted successfully!');
    }

    public function toggleActive($id)
    {
        $banner = Banner::find($id);
        $banner->update(['is_active' => !$banner->is_active]);
        $this->refreshBanners();
    }

    public function resetForm()
    {
        $this->editingBannerId = null;
        $this->type = 'drop';
        $this->title = '';
        $this->subtitle = '';
        $this->description = '';
        $this->media_type = 'image';
        $this->desktop_media = null;
        $this->mobile_media = null;
        $this->desktop_media_url = '';
        $this->mobile_media_url = '';
        
        $this->video_autoplay = true;
        $this->video_loop = true;
        $this->video_muted = true;
        
        $this->drop_date = '';
        $this->stock_count = null;
        $this->notify_enabled = false;
        
        $this->instagram_hashtag = '';
        $this->tiktok_hashtag = '';
        $this->social_feed_enabled = false;
        
        $this->show_view_count = false;
        $this->show_purchase_ticker = false;
        $this->show_stock_ticker = false;
        
        $this->text_position = 'center';
        $this->overlay_type = 'gradient';
        $this->overlay_opacity = 50;
        $this->background_color = '';
        $this->text_color = '';
        $this->accent_color = '';
        
        $this->entrance_animation = 'fade';
        $this->scroll_effect = 'none';
        
        $this->cta_text = '';
        $this->cta_url = '';
        $this->cta_style = 'primary';
        
        $this->badge_text = '';
        $this->badge_style = 'new';
        
        $this->position = 'hero';
        $this->display_priority = 0;
        
        $this->is_active = true;
        $this->start_date = '';
        $this->end_date = '';
    }

    public function render()
    {
        return view('livewire.admin.banner-manager');
    }
}
