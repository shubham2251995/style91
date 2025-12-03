{{-- Clean Modern Footer - Bewakoof.com Inspired --}}
<footer class="bg-gray-50 border-t border-gray-200 mt-20">
    
    {{-- Newsletter Section --}}
    <div class="bg-white border-b border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    Join the Club. Get the Style.
                </h3>
                
                <p class="text-gray-600 mb-6">Sign up for exclusive offers, original stories, events and more.</p>

                <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" 
                           placeholder="Enter your email"
                           class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-black focus:ring-1 focus:ring-black transition-all">
                    
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors whitespace-nowrap">
                        Subscribe
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-4">By signing up, you agree to our Privacy Policy and Terms of Service.</p>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
            {{-- Shop --}}
            <div>
                <h4 class="text-gray-900 font-bold text-sm mb-4 uppercase">Customer Service</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-black transition text-sm">Contact Us</a></li>
                    <li><a href="{{ route('track-order') }}" class="text-gray-600 hover:text-black transition text-sm">Track Order</a></li>
                    <li><a href="{{ route('returns') }}" class="text-gray-600 hover:text-black transition text-sm">Return Order</a></li>
                    <li><a href="{{ route('shipping') }}" class="text-gray-600 hover:text-black transition text-sm">Cancel Order</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="text-gray-900 font-bold text-sm mb-4 uppercase">Company</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-black transition text-sm">About Us</a></li>
                    <li><a href="{{ route('careers') }}" class="text-gray-600 hover:text-black transition text-sm">Careers</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-600 hover:text-black transition text-sm">Terms & Conditions</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-600 hover:text-black transition text-sm">Privacy Policy</a></li>
                </ul>
            </div>

            {{-- Connect --}}
            <div>
                <h4 class="text-gray-900 font-bold text-sm mb-4 uppercase">Connect with Us</h4>
                <div class="flex gap-3 mb-4">
                    <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-all">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-all">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-all">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
            </div>

            {{-- 100% Secure Payment --}}
            <div>
                <h4 class="text-gray-900 font-bold text-sm mb-4 uppercase">100% Secure Payment</h4>
                <div class="flex flex-wrap gap-2">
                    <div class="w-12 h-8 bg-white border border-gray-300 rounded flex items-center justify-center">
                        <span class="text-xs font-bold text-gray-600">VISA</span>
                    </div>
                    <div class="w-12 h-8 bg-white border border-gray-300 rounded flex items-center justify-center">
                        <span class="text-xs font-bold text-gray-600">MC</span>
                    </div>
                    <div class="w-12 h-8 bg-white border border-gray-300 rounded flex items-center justify-center">
                        <span class="text-xs font-bold text-gray-600">UPI</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trust Badges --}}
        <div class="border-t border-gray-200 pt-8 pb-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                    </svg>
                    <p class="text-gray-900 font-bold text-sm">Free Shipping</p>
                    <p class="text-xs text-gray-600">On orders above ₹999</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-gray-900 font-bold text-sm">100% Secure</p>
                    <p class="text-xs text-gray-600">Protected payment</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-gray-900 font-bold text-sm">Easy Returns</p>
                    <p class="text-xs text-gray-600">7-day return policy</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                    <p class="text-gray-900 font-bold text-sm">24/7 Support</p>
                    <p class="text-xs text-gray-600">Always here to help</p>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-200 pt-6 text-center">
            <p class="text-gray-600 text-sm mb-1">&copy; {{ date('Y') }} Style91. All rights reserved.</p>
            <p class="text-xs text-gray-500">Made with ❤️ in India</p>
        </div>
    </div>
</footer>
