@extends('layouts.frontend')

@section('title', $category->name . ' - ' . config('app.name'))

@push('meta')
    <meta name="description" content="{{ $category->meta_description ?? Str::limit($category->description, 160) }}">
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl">{{ $category->description }}</p>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Posts Grid --}}
        <div class="lg:col-span-2">
            @if($posts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <p class="text-gray-500 text-lg">Belum ada artikel di kategori ini.</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-8">

            {{-- Subcategories --}}
            @if(isset($subcategories) && $subcategories->count())
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-lg mb-4">Sub Kategori</h3>
                    <div class="space-y-2">
                        @foreach($subcategories as $sub)
                            <a href="{{ route('category.show', $sub->slug) }}"
                               class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <span class="text-sm font-medium">{{ $sub->name }}</span>
                                <span class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-600 px-2 py-0.5 rounded-full">{{ $sub->posts_count ?? $sub->posts()->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Popular Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Populer</h3>
                @if(isset($popularPosts))
                    <div class="space-y-4">
                        @foreach($popularPosts->take(5) as $index => $post)
                            <a href="{{ route('post.show', $post->slug) }}" class="flex items-start space-x-3 group">
                                <span class="text-2xl font-extrabold text-gray-200 dark:text-gray-600 group-hover:text-blue-700 transition leading-none">{{ $index + 1 }}</span>
                                <div>
                                    <h4 class="text-sm font-semibold leading-snug group-hover:text-blue-700 transition">{{ Str::limit($post->title, 70) }}</h4>
                                    <span class="text-xs text-gray-500 mt-1 block">{{ $post->published_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tags --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Tag</h3>
                @if(isset($tags))
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('tag.show', $tag->slug) }}"
                               class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 text-sm rounded-full transition">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Ad --}}
            <x-ad-slot location="sidebar" />
        </aside>
    </div>
</div>
@endsection
