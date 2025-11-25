<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewForm extends Component
{
    public $productId;
    public $rating = 5;
    public $comment = '';
    public $submitted = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        // Check if user already reviewed
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $this->productId)
            ->first();

        if ($existing) {
            session()->flash('error', 'You have already reviewed this product.');
            return;
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'verified_purchase' => false, // TODO: Check if user purchased
        ]);

        $this->submitted = true;
        $this->dispatch('review-submitted');
        session()->flash('success', 'Review submitted successfully!');
    }

    public function render()
    {
        $userHasReviewed = Auth::check() 
            ? Review::where('user_id', Auth::id())->where('product_id', $this->productId)->exists()
            : false;

        $reviews = Review::where('product_id', $this->productId)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->get();

        $averageRating = Review::getAverageRating($this->productId);
        $reviewCount = Review::getReviewCount($this->productId);

        return view('livewire.review-form', [
            'userHasReviewed' => $userHasReviewed,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'reviewCount' => $reviewCount,
        ]);
    }
}
