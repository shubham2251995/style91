<?php

namespace App\Livewire\Editorial;

use Livewire\Component;
use App\Models\Article;

class Index extends Component
{
    public $category = 'all';

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $query = Article::latest();

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        return view('livewire.editorial.index', [
            'featured' => Article::where('is_featured', true)->first(),
            'articles' => $query->get(),
        ])->layout('components.layouts.app');
    }
}
