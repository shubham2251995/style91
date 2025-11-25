<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\SiteSettingsService;
use Illuminate\Support\Facades\Log;

class SiteSettings extends Component
{
    public $activeTab = 'branding';
    
    // Branding
    public $site_name = '';
    public $site_tagline = '';
    public $logo_url = '';
    public $favicon_url = '';
    
    // Contact
    public $contact_email = '';
    public $contact_phone = '';
    public $contact_address = '';
    
    // Social
    public $facebook_url = '';
    public $instagram_url = '';
    public $twitter_url = '';
    public $youtube_url = '';
    public $tiktok_url = '';
    
    // SEO
    public $meta_title = '';
    public $meta_description = '';
    public $meta_keywords = '';
    public $og_image = '';
    
    // Content
    public $footer_text = '';
    public $welcome_message = '';

    protected $settingsService;

    public function mount()
    {
        $this->settingsService = app(SiteSettingsService::class);
        $this->loadSettings();
    }

    public function loadSettings()
    {
        try {
            $settings = $this->settingsService->all();
            
            // Branding
            $this->site_name = $settings['site_name'] ?? 'Style91';
            $this->site_tagline = $settings['site_tagline'] ?? 'Streetwear Revolution';
            $this->logo_url = $settings['logo_url'] ?? '';
            $this->favicon_url = $settings['favicon_url'] ?? '';
            
            // Contact
            $this->contact_email = $settings['contact_email'] ?? 'contact@style91.com';
            $this->contact_phone = $settings['contact_phone'] ?? '';
            $this->contact_address = $settings['contact_address'] ?? '';
            
            // Social
            $this->facebook_url = $settings['facebook_url'] ?? '';
            $this->instagram_url = $settings['instagram_url'] ?? '';
            $this->twitter_url = $settings['twitter_url'] ?? '';
            $this->youtube_url = $settings['youtube_url'] ?? '';
            $this->tiktok_url = $settings['tiktok_url'] ?? '';
            
            // SEO
            $this->meta_title = $settings['meta_title'] ?? 'Style91 | Premium Streetwear';
            $this->meta_description = $settings['meta_description'] ?? 'Discover exclusive streetwear drops and premium fashion';
            $this->meta_keywords = $settings['meta_keywords'] ?? 'streetwear, fashion, style91';
            $this->og_image = $settings['og_image'] ?? '';
            
            // Content
            $this->footer_text = $settings['footer_text'] ?? 'Built for the culture.';
            $this->welcome_message = $settings['welcome_message'] ?? 'Welcome to Style91';
        } catch (\Exception $e) {
            Log::error('Error loading site settings: ' . $e->getMessage());
        }
    }

    public function save()
    {
        try {
            // Branding
            $this->settingsService->set('site_name', $this->site_name, 'branding');
            $this->settingsService->set('site_tagline', $this->site_tagline, 'branding');
            $this->settingsService->set('logo_url', $this->logo_url, 'branding', 'url');
            $this->settingsService->set('favicon_url', $this->favicon_url, 'branding', 'url');
            
            // Contact
            $this->settingsService->set('contact_email', $this->contact_email, 'contact', 'email');
            $this->settingsService->set('contact_phone', $this->contact_phone, 'contact');
            $this->settingsService->set('contact_address', $this->contact_address, 'contact');
            
            // Social
            $this->settingsService->set('facebook_url', $this->facebook_url, 'social', 'url');
            $this->settingsService->set('instagram_url', $this->instagram_url, 'social', 'url');
            $this->settingsService->set('twitter_url', $this->twitter_url, 'social', 'url');
            $this->settingsService->set('youtube_url', $this->youtube_url, 'social', 'url');
            $this->settingsService->set('tiktok_url', $this->tiktok_url, 'social', 'url');
            
            // SEO
            $this->settingsService->set('meta_title', $this->meta_title, 'seo');
            $this->settingsService->set('meta_description', $this->meta_description, 'seo');
            $this->settingsService->set('meta_keywords', $this->meta_keywords, 'seo');
            $this->settingsService->set('og_image', $this->og_image, 'seo', 'url');
            
            // Content
            $this->settingsService->set('footer_text', $this->footer_text, 'content');
            $this->settingsService->set('welcome_message', $this->welcome_message, 'content');
            
            // Clear cache
            $this->settingsService->clearCache();
            
            session()->flash('message', 'Settings saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving site settings: ' . $e->getMessage());
            session()->flash('error', 'Failed to save settings.');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.admin.site-settings');
    }
}
