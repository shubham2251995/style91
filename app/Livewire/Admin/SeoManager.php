<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SeoManager extends Component
{
    public $globalTitle;
    public $globalDescription;
    public $globalKeywords;

    public function mount()
    {
        $this->globalTitle = \App\Models\SeoSetting::where('key', 'global_title')->value('value') ?? config('app.name', 'Style91');
        $this->globalDescription = \App\Models\SeoSetting::where('key', 'global_description')->value('value') ?? 'Style91 - The ultimate destination for premium streetwear.';
        $this->globalKeywords = \App\Models\SeoSetting::where('key', 'global_keywords')->value('value') ?? 'streetwear, fashion, style91';
    }

    public function save()
    {
        \App\Models\SeoSetting::updateOrCreate(['key' => 'global_title'], ['value' => $this->globalTitle]);
        \App\Models\SeoSetting::updateOrCreate(['key' => 'global_description'], ['value' => $this->globalDescription]);
        \App\Models\SeoSetting::updateOrCreate(['key' => 'global_keywords'], ['value' => $this->globalKeywords]);

        session()->flash('message', 'SEO Settings Updated!');
    }

    public function render()
    {
        return view('livewire.admin.seo-manager')->layout('components.layouts.app');
    }
}
