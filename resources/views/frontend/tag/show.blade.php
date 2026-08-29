@extends('layouts.frontend')

@section('title', '#' . $tag->name . ' - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">#{{ $tag->name }}</span>
    </nav>

    {{-- Tag Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
            <span class="text-blue-700">#</span>{{ $tag->name }}
        </h1>
        @if($tag->description)
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">{{ $tag->description }}</p>
        @endif
    </div>

    {{-- Posts --}}
    @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            <p class="text-gray-500 text-lg">Tidak ada artikel dengan tag ini.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-700 hover:underline text-sm font-medium">Kembali ke beranda</a>
        </div>
    @endif
</div>
@endsection
