@extends('layouts.frontend')

@section('title', 'Video - ' . config('app.name'))

@push('meta')
    <meta name="description" content="Kumpulan video berita dan liputan terkini dari Poros Aktual.">
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">Video</span>
    </nav>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3 flex items-center space-x-3">
            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <span>Video</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Kumpulan video berita dan liputan terkini.</p>
    </div>

    {{-- Category Filter --}}
    @if(isset($categories) && $categories->count())
        <div class="flex items-center space-x-2 mb-8 overflow-x-auto pb-2">
            <a href="{{ route('video.index') }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ !request('category') ? 'bg-blue-700 text-white' : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('video.index', ['category' => $cat->slug]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-blue-700 text-white' : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- Video Grid --}}
    @if(isset($videos) && $videos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div class="group">
                    <div class="aspect-video rounded-xl overflow-hidden bg-gray-200 dark:bg-gray-700 mb-3 relative">
                        @if($video->youtube_id)
                            <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}"
                                    class="w-full h-full" allowfullscreen loading="lazy"
                                    title="{{ $video->title }}"></iframe>
                        @else
                            <a href="{{ route('post.show', $video->slug) }}">
                                <img src="{{ $video->featured_image_url }}" alt="{{ $video->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition">
                                    <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                    <div>
                        @if($video->category)
                            <a href="{{ route('category.show', $video->category->slug) }}"
                               class="text-xs text-blue-700 font-semibold hover:underline">{{ $video->category->name }}</a>
                        @endif
                        <h3 class="font-semibold mt-1 group-hover:text-blue-700 transition">
                            <a href="{{ route('post.show', $video->slug) }}">{{ Str::limit($video->title, 80) }}</a>
                        </h3>
                        <div class="flex items-center space-x-2 mt-2 text-xs text-gray-500">
                            <span>{{ $video->author->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $video->published_at->diffForHumans() }}</span>
                            @if($video->views_count)
                                <span>&middot;</span>
                                <span>{{ number_format($video->views_count) }} views</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $videos->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <p class="text-gray-500 text-lg">Belum ada video tersedia.</p>
        </div>
    @endif
</div>
@endsection
