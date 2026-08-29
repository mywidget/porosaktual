@extends('layouts.frontend')

@section('title', $author->name . ' - Penulis - ' . config('app.name'))

@push('meta')
    <meta name="description" content="{{ $author->bio ?? 'Artikel oleh ' . $author->name . ' di ' . config('app.name') }}">
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">Penulis</span>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">{{ $author->name }}</span>
    </nav>

    {{-- Author Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-8 mb-10">
        <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
            <img src="{{ $author->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&size=128' }}"
                 alt="{{ $author->name }}"
                 class="w-24 h-24 rounded-full object-cover border-4 border-blue-100 dark:border-blue-900">
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-2xl font-extrabold">{{ $author->name }}</h1>
                @if($author->bio)
                    <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">{{ $author->bio }}</p>
                @endif
                <div class="flex items-center justify-center sm:justify-start space-x-4 mt-4 text-sm text-gray-500">
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>{{ $author->posts_count ?? $author->posts()->count() }} artikel</span>
                    </span>
                </div>
                {{-- Social Links --}}
                @if($author->social_links)
                    <div class="flex items-center justify-center sm:justify-start space-x-3 mt-4">
                        @foreach($author->social_links as $platform => $url)
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-700 transition">
                                    @if($platform === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                    @elseif($platform === 'facebook')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    @elseif($platform === 'instagram')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Author's Posts --}}
    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
        <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
        <span>Artikel oleh {{ $author->name }}</span>
    </h2>

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
            <p class="text-gray-500 text-lg">Belum ada artikel dari penulis ini.</p>
        </div>
    @endif
</div>
@endsection
