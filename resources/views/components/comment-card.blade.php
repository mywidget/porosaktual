@props(['comment', 'depth' => 0])

<div class="{{ $depth > 0 ? 'ml-8 md:ml-12 mt-4' : 'mt-6' }}">
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm p-5 border border-gray-100 dark:border-gray-700">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr($comment->name ?? 'A', 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-semibold text-gray-900 dark:text-white text-sm">
                        {{ $comment->name }}
                    </span>
                    @if($comment->user_id)
                        <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-medium">
                            Penulis
                        </span>
                    @endif
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>

                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                    {!! nl2br(e($comment->content)) !!}
                </div>

                <div class="mt-3 flex items-center gap-3">
                    @auth
                        <button
                            x-data="{ replying: false }"
                            @click="replying = !replying"
                            class="text-xs text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors flex items-center gap-1"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Balas
                        </button>
                    @endauth

                    @if($comment->replies && $comment->replies->count())
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            {{ $comment->replies->count() }} balasan
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($comment->replies && $comment->replies->count())
        @foreach($comment->replies as $reply)
            <x-comment-card :comment="$reply" :depth="$depth + 1" />
        @endforeach
    @endif
</div>