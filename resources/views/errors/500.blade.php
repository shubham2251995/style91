@extends('components.layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <h1 class="text-9xl font-black text-red-500 mb-4">500</h1>
    <h2 class="text-2xl font-bold text-brand-dark mb-2">System Glitch</h2>
    <p class="text-gray-500 mb-8">Something went wrong on our end. The singularity is acting up.</p>
    <a href="{{ route('home') }}" class="bg-brand-black text-white px-8 py-3 rounded-full font-bold hover:bg-brand-accent hover:text-brand-black transition-all">
        TRY AGAIN
    </a>
</div>
@endsection
