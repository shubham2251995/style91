<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class InstagramFeed extends Component
{
    public $posts = [];
    public $limit = 6;

    public function mount($limit = 6)
    {
        $this->limit = $limit;
        $this->loadPosts();
    }

    public function loadPosts()
    {
        // Instagram API integration
        $accessToken = config('services.instagram.access_token');
        
        if (!$accessToken) {
            return;
        }

        try {
            $response = Http::get("https://graph.instagram.com/me/media", [
                'fields' => 'id,caption,media_type,media_url,permalink,timestamp',
                'access_token' => $accessToken,
                'limit' => $this->limit
            ]);

            if ($response->successful()) {
                $this->posts = $response->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
            // Log error or handle gracefully
            $this->posts = [];
        }
    }

    public function render()
    {
        return view('livewire.instagram-feed');
    }
}
