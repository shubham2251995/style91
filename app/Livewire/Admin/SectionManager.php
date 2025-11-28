<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\HomepageSection;
use Livewire\WithFileUploads;

class SectionManager extends Component
{
    use WithFileUploads;

    public $sections;
    public $editingSectionId = null;

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

    public function mount()
    {
        $this->refreshSections();
    }

    public function refreshSections()
    {
        $this->sections = HomepageSection::orderBy('order')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->editingSectionId = null;
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
        ];

        if ($this->newImage) {
            $path = $this->newImage->store('sections', 'public');
            $data['image_url'] = '/storage/' . $path;
        } elseif (!$this->editingSectionId && !$this->image_url) {
             // Default placeholder if creating new and no image
             $data['image_url'] = '/images/placeholder.jpg';
        }

        if ($this->editingSectionId) {
            HomepageSection::find($this->editingSectionId)->update($data);
        } else {
            HomepageSection::create($data);
        }

        $this->resetForm();
        $this->refreshSections();
    }

    public function delete($id)
    {
        HomepageSection::find($id)->delete();
        $this->refreshSections();
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
        $this->order = 0;
        $this->is_active = true;
        $this->newImage = null;
    }

    public function render()
    {
        return view('livewire.admin.section-manager');
    }
}
