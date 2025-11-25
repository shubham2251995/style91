<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    public $product;
    public $rating = 5;
    public $reviewText = '';
    public $showReviewForm = false;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to submit a review.');
            return redirect()->route('login');
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'reviewText' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $this->product->id)
                                 ->where('user_id', Auth::id())
                                 ->first();

        if ($existingReview) {
            session()->flash('error', 'You have already reviewed this product.');
            return;
        }

        // Check if user purchased this product (optional - mark as verified)
        $hasPurchased = Auth::user()->orders()
                            ->whereHas('items', function($q) {
                                $q->where('product_id', $this->product->id);
                            })
                            ->where('status', 'delivered')
                            ->exists();

        Review::create([
            'product_id' => $this->product->id,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'review_text' => $this->reviewText,
            'is_verified' => $hasPurchased,
            'is_approved' => false, // Requires admin approval
        ]);

        session()->flash('message', 'Thank you! Your review has been submitted and will appear after approval.');
        
        $this->reset(['rating', 'reviewText', 'showReviewForm']);
        $this->product->refresh();
    }

    public function markHelpful($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->increment('helpful_count');
    }

    public function markNotHelpful($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->increment('not_helpful_count');
    }

    public function render()
    {
        $reviews = $this->product->reviews()
                                 ->approved()
                                 ->with('user')
                                 ->latest()
                                 ->paginate(10);

        $avgRating = round($this->product->averageRating(), 1);
        $reviewCount = $this->product->reviewsCount();

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->product->reviews()->approved()->where('rating', $i)->count();
            $percentage = $reviewCount > 0 ? round(($count / $reviewCount) * 100) : 0;
            $ratingDistribution[$i] = ['count' => $count, 'percentage' => $percentage];
        }

        return view('livewire.product-reviews', [
            'reviews' => $reviews,
            'avgRating' => $avgRating,
            'reviewCount' => $reviewCount,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }
}
