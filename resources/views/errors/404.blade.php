@extends('components.layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <h1 class="text-9xl font-black text-brand-accent mb-4">404</h1>
    <h2 class="text-2xl font-bold text-brand-dark mb-2">Lost in the Metaverse?</h2>
    <p class="text-gray-500 mb-8">The page you're looking for has been deleted or never existed.</p>
    <a href="{{ route('home') }}" class="bg-brand-black text-white px-8 py-3 rounded-full font-bold hover:bg-brand-accent hover:text-brand-black transition-all">
        RETURN TO BASE
    </a>
</div>
@endsection
