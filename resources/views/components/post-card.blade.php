@props(['post'])

<article class="rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-all duration-300 hover:scale-[1.02] group">
        <div class="relative overflow-hidden">
            <img
                src="{{ $post->featured_image_url }}"
                alt="{{ $post->title }}"
                loading="lazy"
                class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110"
                onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'"
            >
            @if($post->category)
                <div class="absolute top-3 left-3">
                    <x-category-badge :category="$post->category" />
                </div>
            @endif
        </div>

    <div class="p-5">

        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
            <a href="{{ route('post.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h3>

        @if($post->excerpt)
            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                {{ Str::limit(strip_tags($post->excerpt), 120) }}
            </p>
        @endif

        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
                @if($post->author)
                    <div class="flex items-center gap-1.5">
                        @if($post->author->avatar)
                            <img src="{{ asset('storage/' . $post->author->avatar) }}" alt="{{ $post->author->name }}" class="w-6 h-6 rounded-full object-cover">
                        @else
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                        @endif
                        <span>{{ $post->author->name }}</span>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $post->published_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($post->views_count ?? 0) }}
                </span>
            </div>
        </div>
    </div>
</article>