<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SizeGuide;

class SizeGuideModal extends Component
{
    public $product;
    public $sizeGuide;
    public $isOpen = false;
    
    // Fit finder
    public $userMeasurements = [];
    public $recommendedSize = null;

    public function mount($product = null)
    {
        $this->product = $product;
        
        if ($product && $product->category_id) {
            $this->sizeGuide = SizeGuide::active()
                ->where(function($q) use ($product) {
                    $q->where('category_id', $product->category_id)
                      ->orWhereNull('category_id');
                })
                ->first();
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['userMeasurements', 'recommendedSize']);
    }

    public function findMySize()
    {
        if (!$this->sizeGuide) {
            return;
        }

        $this->recommendedSize = $this->sizeGuide->getSizeRecommendation($this->userMeasurements);
    }

    public function render()
    {
        return view('livewire.size-guide-modal');
    }
}
