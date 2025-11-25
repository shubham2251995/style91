<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Section;
use Illuminate\Support\Facades\Log;

class SectionManager extends Component
{
    public $sections = [];
    public $showModal = false;
    public $editingSection = null;
    
    // Form fields
    public $type = 'hero';
    public $title = '';
    public $content = [];
    public $order = 0;
    public $is_active = true;
    public $rules = [];

    public $sectionTypes = [
        'hero' => 'Hero/Slider',
        'categories' => 'Categories Grid',
        'featured_products' => 'Featured Products',
        'banner' => 'Banner',
        'text_block' => 'Text Block',
        'video' => 'Video',
        'testimonials' => 'Testimonials',
        'custom_html' => 'Custom HTML',
    ];

    public function mount()
    {
        $this->loadSections();
    }

    public function loadSections()
    {
        try {
            $this->sections = Section::ordered()->get()->toArray();
        } catch (\Exception $e) {
            Log::error('Error loading homepage sections: ' . $e->getMessage());
            $this->sections = [];
        }
    }

    public function openModal($type = 'hero')
    {
        $this->reset(['type', 'title', 'content', 'order', 'is_active', 'rules', 'editingSection']);
        $this->type = $type;
        $this->order = count($this->sections);
        $this->showModal = true;
    }

    public function edit($id)
    {
        try {
            $section = Section::findOrFail($id);
            $this->editingSection = $section->id;
            $this->type = $section->type;
            $this->title = $section->title;
            $this->content = $section->content ?? [];
            $this->order = $section->order;
            $this->is_active = $section->is_active;
            $this->rules = $section->rules ?? [];
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Section not found.');
        }
    }

    public function save()
    {
        try {
            $data = [
                'type' => $this->type,
                'title' => $this->title,
                'content' => $this->content,
                'order' => $this->order,
                'is_active' => $this->is_active,
                'rules' => $this->rules,
            ];

            if ($this->editingSection) {
                Section::find($this->editingSection)->update($data);
                session()->flash('message', 'Section updated successfully.');
            } else {
                Section::create($data);
                session()->flash('message', 'Section created successfully.');
            }

            $this->closeModal();
            $this->loadSections();
        } catch (\Exception $e) {
            Log::error('Error saving section: ' . $e->getMessage());
            session()->flash('error', 'Failed to save section.');
        }
    }

    public function delete($id)
    {
        try {
            Section::destroy($id);
            session()->flash('message', 'Section deleted successfully.');
            $this->loadSections();
        } catch (\Exception $e) {
            Log::error('Error deleting section: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete section.');
        }
    }

    public function toggleActive($id)
    {
        try {
            $section = Section::find($id);
            $section->is_active = !$section->is_active;
            $section->save();
            $this->loadSections();
        } catch (\Exception $e) {
            Log::error('Error toggling section: ' . $e->getMessage());
        }
    }

    public function updateOrder($newOrder)
    {
        try {
            foreach ($newOrder as $index => $id) {
                Section::where('id', $id)->update(['order' => $index]);
            }
            $this->loadSections();
        } catch (\Exception $e) {
            Log::error('Error updating section order: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['type', 'title', 'content', 'order', 'is_active', 'rules', 'editingSection']);
    }

    public function render()
    {
        return view('livewire.admin.section-manager');
    }
}
