<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SystemConfiguration;
use App\Services\NavigationService;

class HeaderFooterManager extends Component
{
    public $headerLinks = [];
    public $footerColumns = [];
    public $socialLinks = [];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $service = new NavigationService();
        
        // Load or init Header
        $this->headerLinks = $service->getHeader();

        // Load or init Footer
        $this->footerColumns = $service->getFooter();
        
        // Load or init Socials
        $this->socialLinks = $service->getSocials();
    }

    public function addHeaderLink()
    {
        $this->headerLinks[] = ['label' => 'New Link', 'url' => '#'];
    }

    public function removeHeaderLink($index)
    {
        unset($this->headerLinks[$index]);
        $this->headerLinks = array_values($this->headerLinks);
    }

    public function addFooterColumn()
    {
        $this->footerColumns[] = [
            'title' => 'New Column',
            'links' => []
        ];
    }

    public function removeFooterColumn($index)
    {
        unset($this->footerColumns[$index]);
        $this->footerColumns = array_values($this->footerColumns);
    }

    public function addFooterLink($columnIndex)
    {
        $this->footerColumns[$columnIndex]['links'][] = ['label' => 'New Link', 'url' => '#'];
    }

    public function removeFooterLink($columnIndex, $linkIndex)
    {
        unset($this->footerColumns[$columnIndex]['links'][$linkIndex]);
        $this->footerColumns[$columnIndex]['links'] = array_values($this->footerColumns[$columnIndex]['links']);
    }

    public function save()
    {
        SystemConfiguration::updateOrCreate(
            ['key' => 'header_links'],
            ['value' => json_encode($this->headerLinks), 'group' => 'navigation']
        );

        SystemConfiguration::updateOrCreate(
            ['key' => 'footer_columns'],
            ['value' => json_encode($this->footerColumns), 'group' => 'navigation']
        );

        SystemConfiguration::updateOrCreate(
            ['key' => 'social_links'],
            ['value' => json_encode($this->socialLinks), 'group' => 'navigation']
        );

        app(NavigationService::class)->clearCache();

        session()->flash('message', 'Navigation Settings Updated!');
    }

    public function render()
    {
        return view('livewire.admin.header-footer-manager')->layout('components.layouts.admin');
    }
}
