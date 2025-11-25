<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;
use App\Models\Product;

class ReviewManager extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $filterRating = '';
    public $filterStatus = 'pending'; // pending, approved, all
    public $selectedReview;
    public $isDetailsOpen = false;

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function viewReview($id)
    {
        $this->selectedReview = Review::with(['product', 'user'])->findOrFail($id);
        $this->isDetailsOpen = true;
    }

    public function closeDetails()
    {
        $this->isDetailsOpen = false;
        $this->selectedReview = null;
    }

    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        session()->flash('message', 'Review approved successfully.');
        
        if ($this->selectedReview && $this->selectedReview->id == $id) {
            $this->selectedReview = Review::with(['product', 'user'])->findOrFail($id);
        }
    }

    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = false;
        $review->save();

        session()->flash('message', 'Review rejected.');
        
        if ($this->selectedReview && $this->selectedReview->id == $id) {
            $this->selectedReview = Review::with(['product', 'user'])->findOrFail($id);
        }
    }

    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        session()->flash('message', 'Review deleted successfully.');
        $this->closeDetails();
    }

    public function render()
    {
        $query = Review::with(['product', 'user']);

        // Search
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('review_text', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('product', function($pq) {
                      $pq->where('name', 'like', '%' . $this->searchTerm . '%');
                  })
                  ->orWhereHas('user', function($uq) {
                      $uq->where('name', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }

        // Filter by rating
        if ($this->filterRating) {
            $query->where('rating', $this->filterRating);
        }

        // Filter by status
        if ($this->filterStatus === 'approved') {
            $query->where('is_approved', true);
        } elseif ($this->filterStatus === 'pending') {
            $query->where('is_approved', false);
        }

        $reviews = $query->latest()->paginate(20);

        // Stats
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('is_approved', false)->count(),
            'approved' => Review::where('is_approved', true)->count(),
            'avg_rating' => round(Review::approved()->avg('rating'), 1),
        ];

        return view('livewire.admin.review-manager', [
            'reviews' => $reviews,
            'stats' => $stats,
        ]);
    }
}
