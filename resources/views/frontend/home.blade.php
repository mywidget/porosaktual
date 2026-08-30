@extends('layouts.frontend')

@section('title', $settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya')

@push('meta')
    <meta name="description" content="{{ $settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia. Temukan berita politik, nasional, ekonomi, teknologi, olahraga, dan lifestyle terbaru.' }}">
    <meta name="keywords" content="{{ $settings['seo_meta_keywords'] ?? 'berita, news, Indonesia, terkini, politik, nasional, ekonomi, teknologi, olahraga, lifestyle' }}">
    <meta property="og:title" content="{{ $settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya' }}">
    <meta property="og:description" content="{{ $settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia. Temukan berita politik, nasional, ekonomi, teknologi, olahraga, dan lifestyle terbaru.' }}">
    <meta property="og:image" content="{{ ($settings['seo_og_image'] ?? null) ? asset('storage/' . $settings['seo_og_image']) : asset('images/no-image.svg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya' }}">
    <meta name="twitter:description" content="{{ $settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia.' }}">
    <meta name="twitter:image" content="{{ ($settings['seo_og_image'] ?? null) ? asset('storage/' . $settings['seo_og_image']) : asset('images/no-image.svg') }}">
@endpush

@section('content')

{{-- Hero Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Hero Post --}}
        @if(isset($heroPost))
            <div class="lg:col-span-2">
                <a href="{{ route('post.show', $heroPost->slug) }}" class="group block relative rounded-2xl overflow-hidden aspect-[16/9]">
                    <img src="{{ $heroPost->featured_image_url }}" alt="{{ $heroPost->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
                        <span class="inline-block px-3 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full mb-2 sm:mb-3">{{ $heroPost->category->name }}</span>
                        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-white leading-tight line-clamp-2 sm:line-clamp-3 group-hover:text-blue-300 transition">{{ $heroPost->title }}</h1>
                        <div class="flex items-center space-x-3 mt-2 sm:mt-3 text-gray-300 text-xs sm:text-sm">
                            <span>{{ $heroPost->author->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $heroPost->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        {{-- Side Featured Posts --}}
        <div class="flex flex-col gap-4">
            @if(isset($featuredPosts))
                @foreach($featuredPosts->take(3) as $post)
                    <a href="{{ route('post.show', $post->slug) }}" class="group block relative rounded-xl overflow-hidden aspect-[16/9]">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4">
                            <span class="inline-block px-2 py-0.5 bg-blue-700 text-white text-xs font-semibold rounded-full mb-1 sm:mb-2">{{ $post->category->name }}</span>
                            <h3 class="text-xs sm:text-sm font-bold text-white leading-snug line-clamp-2 group-hover:text-blue-300 transition">{{ Str::limit($post->title, 80) }}</h3>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- Trending Section --}}
@if(isset($trendingPosts) && $trendingPosts->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
            <span>Trending</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($trendingPosts->take(6) as $index => $post)
            <x-post-card :post="$post" :trending="true" :rank="$index + 1" />
        @endforeach
    </div>
</section>
@endif

{{-- Leaderboard Ad --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <x-ad-slot location="header" />
</div>

{{-- Latest News + Sidebar --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
                <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
                <span>Berita Terbaru</span>
            </h2>
            <div class="space-y-6">
                @foreach($latestPosts as $post)
                    <x-post-card-horizontal :post="$post" />
                    @if($loop->iteration === 3)
                        <div class="my-4"><x-ad-slot location="content" /></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-8">
            {{-- Popular Widget --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span>Populer</span>
                </h3>
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

            {{-- Tags Cloud --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Tag Populer</h3>
                @if(isset($popularTags))
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $tag)
                            <a href="{{ route('tag.show', $tag->slug) }}"
                               class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 text-sm rounded-full transition">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

{{-- Newsletter --}}
<div class="bg-blue-700 rounded-xl shadow-sm p-6 text-white">
    <h3 class="font-bold text-lg mb-2">Newsletter</h3>
    <p class="text-blue-100 text-sm mb-4">Dapatkan berita terkini langsung di inbox Anda.</p>
    <form action="#" method="POST" class="space-y-3">
        @csrf
        <input type="email" name="email" placeholder="Email Anda" required
               class="w-full px-4 py-2.5 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-white outline-none">
        <button type="submit" class="w-full px-4 py-2.5 bg-white text-blue-700 font-semibold rounded-lg text-sm hover:bg-gray-100 transition">
            Berlangganan
        </button>
    </form>
</div>

            {{-- Sticky Ad --}}
            <x-ad-slot location="sidebar" :limit="2" />
        </aside>
    </div>
</section>

{{-- Category Sections --}}
@foreach(['politik', 'nasional', 'ekonomi', 'teknologi', 'lifestyle', 'olahraga'] as $categorySlug)
    @php
        $categoryPosts = $categoryPostsMap[$categorySlug] ?? collect();
    @endphp
    @if($categoryPosts->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold flex items-center space-x-2">
                <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
                <span>{{ ucfirst($categorySlug) }}</span>
            </h2>
            <a href="{{ route('category.show', $categorySlug) }}" class="text-sm text-blue-700 hover:text-blue-800 font-medium flex items-center space-x-1">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Headline --}}
            @php $headline = $categoryPosts->first(); @endphp
            <div class="lg:col-span-2">
                <a href="{{ route('post.show', $headline->slug) }}" class="group block relative rounded-2xl overflow-hidden aspect-[16/9]">
                    <img src="{{ $headline->featured_image_url }}" alt="{{ $headline->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block px-3 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full mb-3">{{ $headline->category->name }}</span>
                        <h3 class="text-2xl font-bold text-white leading-tight group-hover:text-blue-300 transition">{{ $headline->title }}</h3>
                        <div class="flex items-center space-x-3 mt-3 text-gray-300 text-sm">
                            <span>{{ $headline->author->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $headline->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            </div>
            {{-- Side posts --}}
            <div class="flex flex-col gap-4">
                @foreach($categoryPosts->skip(1)->take(3) as $post)
                    <a href="{{ route('post.show', $post->slug) }}" class="group block relative rounded-xl overflow-hidden aspect-[16/9]">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="text-sm font-bold text-white leading-snug group-hover:text-blue-300 transition">{{ Str::limit($post->title, 80) }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

{{-- Video Section --}}
@if(isset($videos) && $videos->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold flex items-center space-x-2">
            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <span>Video</span>
        </h2>
        <a href="{{ route('video.index') }}" class="text-sm text-blue-700 hover:text-blue-800 font-medium flex items-center space-x-1">
            <span>Lihat Semua</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($videos->take(6) as $video)
            <div class="group">
                <div class="aspect-video rounded-xl overflow-hidden bg-gray-200 dark:bg-gray-700 mb-3">
                    @if($video->youtube_id)
                        <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                    @else
                        <img src="{{ $video->featured_image_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                    @endif
                </div>
                <h3 class="font-semibold group-hover:text-blue-700 transition">{{ Str::limit($video->title, 70) }}</h3>
                <span class="text-xs text-gray-500 mt-1 block">{{ $video->published_at->diffForHumans() }}</span>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- Editor's Choice --}}
@if(isset($editorsChoice) && $editorsChoice->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        <span>Pilihan Redaksi</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($editorsChoice as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</section>
@endif

{{-- Popular This Week --}}
@if(isset($popularThisWeek) && $popularThisWeek->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
        <span>Populer Minggu Ini</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($popularThisWeek as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</section>
@endif

{{-- Footer Ad --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <x-ad-slot location="footer" />
</div>

@endsection
