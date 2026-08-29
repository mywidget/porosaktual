@props(['withImage' => true])

<style>
    .skeleton-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    @media (prefers-color-scheme: dark) {
        .dark .skeleton-shimmer,
        .skeleton-shimmer-dark {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
        }
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<div class="rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm animate-pulse">
    @if($withImage)
        <div class="skeleton-shimmer w-full h-48"></div>
    @endif

    <div class="p-5 space-y-3">
        <div class="skeleton-shimmer h-4 w-16 rounded-full"></div>

        <div class="space-y-2">
            <div class="skeleton-shimmer h-5 w-full rounded"></div>
            <div class="skeleton-shimmer h-5 w-3/4 rounded"></div>
        </div>

        <div class="space-y-2">
            <div class="skeleton-shimmer h-3 w-full rounded"></div>
            <div class="skeleton-shimmer h-3 w-full rounded"></div>
            <div class="skeleton-shimmer h-3 w-2/3 rounded"></div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <div class="flex items-center gap-2">
                <div class="skeleton-shimmer w-6 h-6 rounded-full"></div>
                <div class="skeleton-shimmer h-3 w-20 rounded"></div>
            </div>
            <div class="skeleton-shimmer h-3 w-16 rounded"></div>
        </div>
    </div>
</div>