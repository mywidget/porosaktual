@props(['post'])

<article class="flex gap-3 p-3 rounded-xl bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-all duration-300 hover:scale-[1.01] group">
    <div class="relative w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden">
        <img
            src="{{ $post->featured_image_url }}"
            alt="{{ $post->title }}"
            loading="lazy"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            style="object-position: {{ $post->featured_image_position ?? 'center' }}"
            onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'"
        >
    </div>

    <div class="flex-1 min-w-0 flex flex-col justify-between">
        <div>
            @if($post->category)
                <x-category-badge :category="$post->category" size="sm" />
            @endif

            <h4 class="text-sm font-bold text-gray-900 dark:text-white mt-1 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <a href="{{ route('post.show', $post->slug) }}">
                    {{ $post->title }}
                </a>
            </h4>
        </div>

        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-2">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $post->published_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</article>