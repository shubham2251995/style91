<div class="space-y-6">
    <!-- Average Rating Display -->
    @if($reviewCount > 0)
        <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
            <div class="text-center">
                <p class="text-4xl font-bold text-brand-dark">{{ number_format($averageRating, 1) }}</p>
                <div class="flex gap-1 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }}</p>
            </div>
        </div>
    @endif

    <!-- Review Form -->
    @if(!$userHasReviewed && auth()->check())
        <div class="bg-gray-50 rounded-xl p-6">
            <h3 class="font-bold text-lg mb-4 text-brand-dark">Write a Review</h3>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="submitReview">
                <!-- Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Your Rating</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button 
                                type="button"
                                wire:click="$set('rating', {{ $i }})"
                                class="focus:outline-none"
                            >
                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }} hover:text-yellow-400 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Your Review (Optional)</label>
                    <textarea 
                        wire:model="comment"
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-accent"
                        placeholder="Share your experience with this product..."
                    ></textarea>
                    @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Submit -->
                <button 
                    type="submit"
                    class="bg-brand-accent text-brand-dark px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition"
                >
                    SUBMIT REVIEW
                </button>
            </form>
        </div>
    @elseif(!auth()->check())
        <div class="bg-gray-50 rounded-xl p-6 text-center">
            <p class="text-gray-600 mb-4">Please log in to write a review</p>
            <a href="{{ route('login') }}" class="inline-block bg-brand-accent text-brand-dark px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition">
                LOG IN
            </a>
        </div>
    @endif

    <!-- Reviews List -->
    @if($reviews->count() > 0)
        <div class="space-y-4">
            <h3 class="font-bold text-lg text-brand-dark">Customer Reviews</h3>
            @foreach($reviews as $review)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="font-bold text-brand-dark">{{ $review->user->name }}</p>
                            <div class="flex gap-1 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                        <p class="text-gray-700 text-sm mt-2">{{ $review->comment }}</p>
                    @endif
                    @if($review->verified_purchase)
                        <span class="inline-block mt-2 text-xs bg-green-100 text-green-600 px-2 py-1 rounded">✓ Verified Purchase</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
