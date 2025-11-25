<div class="bg-white rounded-xl p-6 shadow-sm">
    <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Overall Rating Summary -->
    <div class="flex flex-col md:flex-row gap-8 mb-8 pb-8 border-b">
        <div class="text-center md:text-left">
            <div class="text-5xl font-bold text-gray-900">{{ $avgRating }}</div>
            <div class="flex items-center justify-center md:justify-start my-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-6 h-6 {{ $i <= floor($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <p class="text-sm text-gray-600">Based on {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
        </div>

        <!-- Rating Distribution -->
        <div class="flex-1">
            @foreach($ratingDistribution as $stars => $data)
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm font-medium w-10">{{ $stars }} ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm text-gray-600 w-12 text-right">{{ $data['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Write Review Button -->
    @auth
        @if(!$showReviewForm)
            <button wire:click="$toggle('showReviewForm')" class="mb-6 px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold transition-colors">
                Write a Review
            </button>
        @endif
    @else
        <a href="{{ route('login') }}" class="inline-block mb-6 px-6 py-3 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold transition-colors">
            Login to Write a Review
        </a>
    @endauth

    <!-- Review Form -->
    @if($showReviewForm)
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">Write Your Review</h3>
            <form wire:submit.prevent="submitReview">
                <!-- Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating *</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="text-3xl {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400">
                                ⭐
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Review Text -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Review (Optional)</label>
                    <textarea wire:model="reviewText" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Tell us about your experience with this product..."></textarea>
                    @error('reviewText') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-brand-dark text-white rounded-lg hover:bg-brand-accent hover:text-brand-dark font-bold">
                        Submit Review
                    </button>
                    <button type="button" wire:click="$toggle('showReviewForm')" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Reviews List -->
    <div class="space-y-6">
        @forelse($reviews as $review)
            <div class="border-b pb-6">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                            @if($review->is_verified)
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">✓ Verified Purchase</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                @if($review->review_text)
                    <p class="text-gray-700 mb-3">{{ $review->review_text }}</p>
                @endif

                @if($review->images)
                    <div class="flex gap-2 mb-3">
                        @foreach($review->images as $image)
                            <img src="{{ $image }}" alt="Review image" class="w-20 h-20 object-cover rounded">
                        @endforeach
                    </div>
                @endif

                <div class="flex items-center gap-4 text-sm">
                    <button wire:click="markHelpful({{ $review->id }})" class="text-gray-600 hover:text-gray-900">
                        👍 Helpful ({{ $review->helpful_count }})
                    </button>
                    <button wire:click="markNotHelpful({{ $review->id }})" class="text-gray-600 hover:text-gray-900">
                        👎 Not Helpful ({{ $review->not_helpful_count }})
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p class="text-lg">No reviews yet</p>
                <p class="text-sm">Be the first to review this product!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
