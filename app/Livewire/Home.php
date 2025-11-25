<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\HomepageSection;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    public function render()
    {
        try {
            $sections = HomepageSection::active()
                ->ordered()
                ->get()
                ->filter(function ($section) {
                    // Apply visibility rules
                    $device = request()->userAgent() && strpos(request()->userAgent(), 'Mobile') !== false ? 'mobile' : 'desktop';
                    return $section->isVisibleFor(auth()->user(), $device);
                });
        } catch (\Exception $e) {
            Log::error('Error loading homepage sections: ' . $e->getMessage());
            $sections = collect([]);
        }

        return view('livewire.home', [
            'sections' => $sections,
            'products' => Product::take(4)->get(), // Fallback for legacy support
        ]);
    }
}
