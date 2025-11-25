<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Theme;

class ThemeManager extends Component
{
    use WithFileUploads;

    public $themes;
    public $isModalOpen = false;
    public $themeId;
    public $name;
    public $primaryColor = '#FFE600';
    public $secondaryColor = '#0a0a0a';
    public $accentColor = '#FFE600';
    public $backgroundColor = '#f0f0f0';
    public $textColor = '#0a0a0a';
    public $headingFont = 'Outfit';
    public $bodyFont = 'Outfit';
    public $borderRadius = '0px';
    public $shadowIntensity = 'medium';

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadThemes();
    }

    public function loadThemes()
    {
        $this->themes = Theme::latest()->get();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->primaryColor = '#FFE600';
        $this->secondaryColor = '#0a0a0a';
        $this->accentColor = '#FFE600';
        $this->backgroundColor = '#f0f0f0';
        $this->textColor = '#0a0a0a';
        $this->headingFont = 'Outfit';
        $this->bodyFont = 'Outfit';
        $this->borderRadius = '0px';
        $this->shadowIntensity = 'medium';
        $this->themeId = null;
    }

    public function store()
    {
        $this->validate();

        $colors = [
            'primary' => $this->primaryColor,
            'secondary' => $this->secondaryColor,
            'accent' => $this->accentColor,
            'background' => $this->backgroundColor,
            'text' => $this->textColor,
        ];

        $fonts = [
            'heading' => $this->headingFont,
            'body' => $this->bodyFont,
        ];

        $styles = [
            'borderRadius' => $this->borderRadius,
            'shadowIntensity' => $this->shadowIntensity,
        ];

        Theme::updateOrCreate(['id' => $this->themeId], [
            'name' => $this->name,
            'colors' => $colors,
            'fonts' => $fonts,
            'styles' => $styles,
            'is_active' => false,
        ]);

        session()->flash('message', $this->themeId ? 'Theme Updated Successfully.' : 'Theme Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->loadThemes();
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id);
        $this->themeId = $id;
        $this->name = $theme->name;
        
        $colors = $theme->colors ?? [];
        $this->primaryColor = $colors['primary'] ?? '#FFE600';
        $this->secondaryColor = $colors['secondary'] ?? '#0a0a0a';
        $this->accentColor = $colors['accent'] ?? '#FFE600';
        $this->backgroundColor = $colors['background'] ?? '#f0f0f0';
        $this->textColor = $colors['text'] ?? '#0a0a0a';

        $fonts = $theme->fonts ?? [];
        $this->headingFont = $fonts['heading'] ?? 'Outfit';
        $this->bodyFont = $fonts['body'] ?? 'Outfit';

        $styles = $theme->styles ?? [];
        $this->borderRadius = $styles['borderRadius'] ?? '0px';
        $this->shadowIntensity = $styles['shadowIntensity'] ?? 'medium';

        $this->openModal();
    }

    public function activate($id)
    {
        // Deactivate all themes
        Theme::query()->update(['is_active' => false]);
        
        // Activate the selected theme
        Theme::find($id)->update(['is_active' => true]);
        
        session()->flash('message', 'Theme Activated Successfully.');
        $this->loadThemes();
    }

    public function delete($id)
    {
        $theme = Theme::find($id);
        if ($theme->is_active) {
            session()->flash('error', 'Cannot delete active theme.');
            return;
        }
        
        $theme->delete();
        session()->flash('message', 'Theme Deleted Successfully.');
        $this->loadThemes();
    }

    public function render()
    {
        return view('livewire.admin.theme-manager');
    }
}
