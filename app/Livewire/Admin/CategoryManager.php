<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryManager extends Component
{
    public $categories;
    public $isModalOpen = false;
    public $categoryId;
    public $name;
    public $slug;
    public $description;
    public $parent_id;
    public $image_url;
    public $display_order = 0;
    public $is_active = true;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id',
        'image_url' => 'nullable|url',
        'display_order' => 'integer|min:0',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        // Load root categories with their children
        $this->categories = Category::with('children')->root()->orderBy('display_order')->get();
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
        $this->description = '';
        $this->parent_id = null;
        $this->image_url = '';
        $this->display_order = 0;
        $this->is_active = true;
        $this->meta_title = '';
        $this->meta_description = '';
        $this->meta_keywords = '';
        $this->categoryId = null;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->categoryId) {
            $rules['slug'] = 'required|string|max:255|unique:categories,slug,' . $this->categoryId;
        }

        $this->validate($rules);

        Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'image_url' => $this->image_url,
            'display_order' => $this->display_order,
            'is_active' => $this->is_active,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
        ]);

        session()->flash('message', $this->categoryId ? 'Category Updated Successfully.' : 'Category Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->loadCategories();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->image_url = $category->image_url;
        $this->display_order = $category->display_order;
        $this->is_active = $category->is_active;
        $this->meta_title = $category->meta_title;
        $this->meta_description = $category->meta_description;
        $this->meta_keywords = $category->meta_keywords;

        $this->openModal();
    }

    public function delete($id)
    {
        $category = Category::find($id);
        
        // Check if category has products or children
        if ($category->products()->count() > 0) {
            session()->flash('error', 'Cannot delete category with products. Please reassign products first.');
            return;
        }

        if ($category->children()->count() > 0) {
            session()->flash('error', 'Cannot delete category with subcategories. Please delete subcategories first.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category Deleted Successfully.');
        $this->loadCategories();
    }

    public function toggleActive($id)
    {
        $category = Category::find($id);
        $category->is_active = !$category->is_active;
        $category->save();
        $this->loadCategories();
    }

    public function updatedName($value)
    {
        if (!$this->categoryId) {
            $this->slug = Str::slug($value);
        }
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'allCategories' => Category::orderBy('name')->get(), // For parent dropdown
        ]);
    }
}
