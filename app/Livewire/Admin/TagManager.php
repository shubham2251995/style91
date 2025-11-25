<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagManager extends Component
{
    public $tags;
    public $isModalOpen = false;
    public $tagId;
    public $name;
    public $slug;
    public $color = '#3b82f6';

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:tags,slug',
        'color' => 'required|string',
    ];

    public function mount()
    {
        $this->loadTags();
    }

    public function loadTags()
    {
        $this->tags = Tag::withCount('products')->orderBy('name')->get();
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
        $this->slug = '';
        $this->color = '#3b82f6';
        $this->tagId = null;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->tagId) {
            $rules['slug'] = 'required|string|max:255|unique:tags,slug,' . $this->tagId;
        }

        $this->validate($rules);

        Tag::updateOrCreate(['id' => $this->tagId], [
            'name' => $this->name,
            'slug' => $this->slug,
            'color' => $this->color,
        ]);

        session()->flash('message', $this->tagId ? 'Tag Updated Successfully.' : 'Tag Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->loadTags();
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->color = $tag->color;

        $this->openModal();
    }

    public function delete($id)
    {
        $tag = Tag::find($id);
        
        if ($tag->products()->count() > 0) {
            session()->flash('error', 'Cannot delete tag assigned to products. Please remove from products first.');
            return;
        }

        $tag->delete();
        session()->flash('message', 'Tag Deleted Successfully.');
        $this->loadTags();
    }

    public function updatedName($value)
    {
        if (!$this->tagId) {
            $this->slug = Str::slug($value);
        }
    }

    public function render()
    {
        return view('livewire.admin.tag-manager');
    }
}
