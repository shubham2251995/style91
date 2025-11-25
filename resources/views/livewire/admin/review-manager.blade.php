<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Review Manager</h2>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Total Reviews</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Pending Approval</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Approved</div>
                <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="text-sm text-gray-500">Average Rating</div>
                <div class="text-2xl font-bold text-blue-600">{{ $stats['avg_rating'] }} ⭐</div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search reviews, products, customers..." class="w-full border-gray-300 rounded-lg px-3 py-2">
                <select wire:model.live="filterRating" class="w-full border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
                <select wire:model.live="filterStatus" class="w-full border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Review</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $review->product->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $review->user->name }}</div>
                                @if($review->is_verified)
                                    <span class="text-xs text-green-600">✓ Verified Purchase</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $review->review_text ?? 'No text' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <button wire:click="viewReview({{ $review->id }})" class="text-indigo-600 hover:text-indigo-900">View</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No reviews found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($reviews->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>

        <!-- Review Details Modal -->
        @if($isDetailsOpen && $selectedReview)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $selectedReview->product->name }}</h3>
                                <p class="text-sm text-gray-500">By {{ $selectedReview->user->name }}</p>
                            </div>
                            <button wire:click="closeDetails" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $selectedReview->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                @if($selectedReview->is_verified)
                                    <span class="ml-2 text-sm text-green-600">✓ Verified Purchase</span>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $selectedReview->review_text ?? 'No review text provided' }}</p>
                        </div>

                        @if($selectedReview->images)
                            <div class="mb-4">
                                <h4 class="font-medium mb-2">Images</h4>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($selectedReview->images as $image)
                                        <img src="{{ $image }}" alt="Review image" class="w-full h-24 object-cover rounded">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-500">Helpful: {{ $selectedReview->helpful_count }} | Not Helpful: {{ $selectedReview->not_helpful_count }}</p>
                            <p class="text-sm text-gray-500">Posted: {{ $selectedReview->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        @if(!$selectedReview->is_approved)
                            <button wire:click="approveReview({{ $selectedReview->id }})" class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Approve
                            </button>
                        @else
                            <button wire:click="rejectReview({{ $selectedReview->id }})" class="w-full sm:w-auto px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                Unapprove
                            </button>
                        @endif
                        <button wire:click="deleteReview({{ $selectedReview->id }})" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="confirm('Delete this review?') || event.stopImmediatePropagation()">
                            Delete
                        </button>
                        <button wire:click="closeDetails" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
