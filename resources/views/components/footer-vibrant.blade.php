{{-- Vibrant Youth-Centric Footer --}}
<footer class="bg-gradient-to-b from-black via-gray-900 to-black border-t border-brand-500/30 mt-20">
    
    {{-- Newsletter Section --}}
    <div class="bg-gradient-to-r from-brand-500/20 to-accent-500/20 border-y border-brand-500/30 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-brand-500/20 px-4 py-2 rounded-full mb-4">
                    <svg class="w-5 h-5 text-brand-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span class="text-brand-500 font-bold uppercase text-sm">Exclusive Offers</span>
                </div>

                <h3 class="text-4xl md:text-5xl font-black mb-4">
                    <span class="text-white">Get </span>
                    <span class="text-gradient-vibrant">10% OFF</span>
                    <span class="text-white"> Your First Order!</span>
                </h3>
                
                <p class="text-gray-400 text-lg mb-8">Join 50,000+ style enthusiasts getting exclusive deals & early access to new drops</p>

                <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto" x-data="{ email: '', subscribed: false }" @submit.prevent="subscribed = true; setTimeout(() => subscribed = false, 3000)">
                    <input type="email" 
                           x-model="email"
                           placeholder="Enter your email"
                           required
                           class="flex-1 input-vibrant text-lg py-4 px-6">
                    
                    <button type="submit" class="btn-primary text-lg py-4 px-8 whitespace-nowrap flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Get 10% OFF
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-4">No spam, unsubscribe anytime. By signing up you agree to our Terms & Privacy Policy.</p>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
            {{-- Shop --}}
            <div>
                <h4 class="text-brand-500 font-bold text-lg mb-4 uppercase">Shop</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('new-arrivals') }}" class="text-gray-400 hover:text-brand-500 transition">New Arrivals</a></li>
                    <li><a href="{{ route('search') }}" class="text-gray-400 hover:text-brand-500 transition">All Products</a></li>
                    <li><a href="{{ route('sale') }}" class="text-brand-500 hover:text-accent-500 transition font-bold">Sale 🔥</a></li>
                    <li><a href="{{ route('vault') }}" class="text-electric-500 hover:text-electric-400 transition">Exclusive</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div>
                <h4 class="text-brand-500 font-bold text-lg mb-4 uppercase">Help</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('track-order') }}" class="text-gray-400 hover:text-brand-500 transition">Track Order</a></li>
                    <li><a href="{{ route('returns') }}" class="text-gray-400 hover:text-brand-500 transition">Returns</a></li>
                    <li><a href="{{ route('shipping') }}" class="text-gray-400 hover:text-brand-500 transition">Shipping Info</a></li>
                    <li><a href="{{ route('size-guide') }}" class="text-gray-400 hover:text-brand-500 transition">Size Guide</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-brand-500 transition">Contact Us</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="text-brand-500 font-bold text-lg mb-4 uppercase">Company</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-brand-500 transition">About Us</a></li>
                    <li><a href="{{ route('careers') }}" class="text-gray-400 hover:text-brand-500 transition">Careers</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-brand-500 transition">Terms</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-brand-500 transition">Privacy</a></li>
                </ul>
            </div>

            {{-- Connect --}}
            <div>
                <h4 class="text-brand-500 font-bold text-lg mb-4 uppercase">Connect</h4>
                <div class="flex gap-3 mb-4">
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-brand-500/20 rounded-full flex items-center justify-center transition-all hover:scale-110 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-brand-500/20 rounded-full flex items-center justify-center transition-all hover:scale-110 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-brand-500/20 rounded-full flex items-center justify-center transition-all hover:scale-110 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
                <p class="text-gray-400 text-sm mb-2">Customer Support</p>
                <p class="text-brand-500 font-bold text-lg">1800-XXX-XXXX</p>
                <p class="text-xs text-gray-500">Mon-Sat: 10AM - 7PM</p>
            </div>
        </div>

        {{-- Trust Badges --}}
        <div class="border-t border-brand-500/20 pt-8 pb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-brand-500/20 to-accent-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                        </svg>
                    </div>
                    <p class="text-white font-bold text-sm">Free Shipping</p>
                    <p class="text-xs text-gray-400">On orders above ₹999</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-white font-bold text-sm">Secure Payment</p>
                    <p class="text-xs text-gray-400">100% Protected</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-white font-bold text-sm">Easy Returns</p>
                    <p class="text-xs text-gray-400">7-day return policy</p>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                    </div>
                    <p class="text-white font-bold text-sm">24/7 Support</p>
                    <p class="text-xs text-gray-400">Always here to help</p>
                </div>
            </div>
        </div>

        {{-- Social Proof --}}
        <div class="border-t border-brand-500/20 py-8 text-center">
            <div class="flex flex-wrap items-center justify-center gap-8">
                <div>
                    <p class="text-3xl font-black text-gradient-vibrant">50,000+</p>
                    <p class="text-sm text-gray-400">Happy Customers</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-gradient-vibrant">4.8/5</p>
                    <p class="text-sm text-gray-400">Average Rating</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-gradient-vibrant">10k+</p>
                    <p class="text-sm text-gray-400">Products Sold</p>
                </div>
            </div>
        </div>

        {{-- Payment Methods --}}
        <div class="border-t border-brand-500/20 pt-8 pb-4">
            <p class="text-center text-gray-400 text-sm mb-4">We Accept</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center border border-white/20">
                    <span class="text-xs font-bold text-gray-400">VISA</span>
                </div>
                <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center border border-white/20">
                    <span class="text-xs font-bold text-gray-400">MC</span>
                </div>
                <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center border border-white/20">
                    <span class="text-xs font-bold text-gray-400">UPI</span>
                </div>
                <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center border border-white/20">
                    <span class="text-xs font-bold text-gray-400">GPay</span>
                </div>
                <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center border border-white/20">
                    <span class="text-xs font-bold text-gray-400">PhonePe</span>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-brand-500/20 pt-6 text-center">
            <p class="text-gray-400 text-sm mb-2">&copy; {{ date('Y') }} Style91. All rights reserved.</p>
            <p class="text-xs text-gray-500">Made with <span class="text-red-500">❤</span> for the youth</p>
        </div>
    </div>

    {{-- Back to Top Button --}}
    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-brand-500 to-accent-500 rounded-full flex items-center justify-center shadow-glow-yellow hover:scale-110 transition-transform z-40">
        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</footer>
