<?php

namespace App\Livewire\Editorial;

use Livewire\Component;
use App\Models\Article;

class Show extends Component
{
    public Article $article;

    public function mount($slug)
    {
        $this->article = Article::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.editorial.show')->layout('components.layouts.app');
    }
}
