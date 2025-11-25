<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Page;
use Illuminate\Support\Str;

class PageManager extends Component
{
    public $pages;
    public $isModalOpen = false;
    public $pageId;
    public $title;
    public $slug;
    public $content;
    public $meta_title;
    public $meta_description;
    public $is_active = true;

    protected $rules = [
        'title' => 'required',
        'slug' => 'required|unique:pages,slug',
        'content' => 'nullable',
    ];

    public function render()
    {
        $this->pages = Page::all();
        return view('livewire.admin.page-manager')->layout('components.layouts.app');
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
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->meta_title = '';
        $this->meta_description = '';
        $this->is_active = true;
        $this->pageId = null;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->pageId) {
            $rules['slug'] = 'required|unique:pages,slug,' . $this->pageId;
        }

        $this->validate($rules);

        Page::updateOrCreate(['id' => $this->pageId], [
            'title' => $this->title,
            'slug' => Str::slug($this->slug),
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->pageId ? 'Page Updated Successfully.' : 'Page Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $this->pageId = $id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
        $this->meta_title = $page->meta_title;
        $this->meta_description = $page->meta_description;
        $this->is_active = $page->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Page::find($id)->delete();
        session()->flash('message', 'Page Deleted Successfully.');
    }

    public function updatedTitle($value)
    {
        if (!$this->pageId) {
            $this->slug = Str::slug($value);
        }
    }
}
